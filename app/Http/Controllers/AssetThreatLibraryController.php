<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetThreatLibrary;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetThreatLibraryController extends Controller
{
    // Display all threats in the library
    public function index()
    {
        $threats = AssetThreatLibrary::with(['asset', 'importer'])->latest()->get();

        return view('threat_library.index', compact('threats'));
    }

    // Show form to import new threat
    public function create()
    {
        $assets = Asset::all();

        return view('threat_library.create', compact('assets'));
    }

    // Store imported threat
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,asset_id',
            'threat_name' => 'required|string|max:255',
            'threat_description' => 'required|string',
            'vulnerabilities' => 'required|string',
            'prevention_steps' => 'required|string',
            'severity_level' => 'required|in:Low,Medium,High,Critical',
        ]);

        $validated['imported_by'] = Auth::id();

        $threat = AssetThreatLibrary::create($validated);

        // Log the activity
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'Imported threat information for asset: '.$threat->asset->asset_name,
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('threat_library.index')
            ->with('success', 'Threat information imported successfully!');
    }

    // Show specific threat details
    public function show($id)
    {
        $threat = AssetThreatLibrary::with(['asset', 'importer'])->findOrFail($id);

        return view('threat_library.show', compact('threat'));
    }

    // Show edit form
    public function edit($id)
    {
        $threat = AssetThreatLibrary::findOrFail($id);
        $assets = Asset::all();

        return view('threat_library.edit', compact('threat', 'assets'));
    }

    // Update threat information
    public function update(Request $request, $id)
    {
        $threat = AssetThreatLibrary::findOrFail($id);

        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,asset_id',
            'threat_name' => 'required|string|max:255',
            'threat_description' => 'required|string',
            'vulnerabilities' => 'required|string',
            'prevention_steps' => 'required|string',
            'severity_level' => 'required|in:Low,Medium,High,Critical',
        ]);

        $threat->update($validated);

        // Log the activity
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'Updated threat information for asset: '.$threat->asset->asset_name,
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('threat_library.index')
            ->with('success', 'Threat information updated successfully!');
    }

    // Delete threat
    public function destroy($id)
    {
        $threat = AssetThreatLibrary::findOrFail($id);
        $assetName = $threat->asset->asset_name;

        $threat->delete();

        // Log the activity
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'Deleted threat information for asset: '.$assetName,
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('threat_library.index')
            ->with('success', 'Threat information deleted successfully!');
    }

    // Get threats for specific asset (for AJAX)
    public function getByAsset($assetId)
    {
        $threats = AssetThreatLibrary::where('asset_id', $assetId)->get();

        return response()->json($threats);
    }
}
