<?php

namespace App\Http\Controllers;

use App\Models\AssessmentSession;
use App\Models\Asset;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    public function index()
    {

        // Fetch all assets, including the manager who added them
        $assets = Asset::with('manager')->get();

        return view('assets.index', compact('assets'));
    }

    public function create()
    {

        $assessmentSessions = AssessmentSession::all();

        if (auth()->user()->role !== 'it_security_analyst') {
            abort(403, 'Unauthorized action. You are not authorized to access this.');
        }
        return view('assets.create', compact('assessmentSessions'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'it_security_analyst') {
            abort(403, 'Unauthorized action. You are not authorized to access this.');
        }


        $validated = $request->validate([
            'session_id' => 'required|integer',
            'asset_name' => 'required|string|max:100',
            'asset_type' => 'required|in:Hardware,Software,Database,Cloud Service',
            'description' => 'nullable|string',
        ]);

        // Automatically assign the currently logged-in user as the manager
        // Note: Assumes you have Laravel Auth set up. If not, hardcode an ID like 1 for testing.
        $validated['managed_by'] = Auth::id() ?? 1;

        Asset::create($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Created a new Asset: ' . $request->asset_name,
            'ip_address' => request()->ip()
        ]);

        return redirect()->route('assets.index')->with('success', 'Asset successfully registered.');
    }

    public function show(Asset $asset)
    {

        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        if (auth()->user()->role !== 'it_security_analyst') {
            abort(403, 'Unauthorized action. You are not authorized to access this.');
        }



        return view('assets.edit', compact('asset'));
    }

    public function update(Request $request, Asset $asset)
    {
        if (auth()->user()->role !== 'it_security_analyst') {
            abort(403, 'Unauthorized action. You are not authorized to access this.');
        }

        $validated = $request->validate([
            'asset_name' => 'required|string|max:100',
            'asset_type' => 'required|in:Hardware,Software,Database,Cloud Service',
            'description' => 'nullable|string',
        ]);

        $asset->update($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Updated Asset: ' . $asset->asset_name,
            'ip_address' => request()->ip()
        ]);

        return redirect()->route('assets.index')->with('success', 'Asset updated successfully.');
    }

    public function destroy(Asset $asset)
    {
        if (auth()->user()->role !== 'it_security_analyst') {
            abort(403, 'Unauthorized action. You are not authorized to access this.');
        }

        $asset->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Deleted Asset: ' . $asset->asset_name,
            'ip_address' => request()->ip()
        ]);
        return redirect()->route('assets.index')->with('success', 'Asset deleted successfully.');
    }
}
