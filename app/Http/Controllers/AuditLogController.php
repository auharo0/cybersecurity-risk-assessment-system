<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        // Start query and eager load the user relationship
        $query = AuditLog::with('user')->orderBy('created_at', 'desc');

        // Simple text filter for the 'action' column
        if ($request->filled('search')) {
            $query->where('action', 'like', '%' . $request->search . '%');
        }

        $logs = $query->paginate(50)->withQueryString();

        return view('audit_logs', compact('logs'));
    }
}
