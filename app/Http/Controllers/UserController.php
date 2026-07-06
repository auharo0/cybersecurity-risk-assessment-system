<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'administrator') {
            abort(403, 'Unauthorized action. Only administrators can delete users.');
        }
        $users = User::latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'administrator') {
            abort(403, 'Unauthorized action. Only administrators can delete users.');
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'administrator') {
            abort(403, 'Unauthorized action. Only administrators can delete users.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required', 'in:administrator,it_security_analyst,organization_manager'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Created User: ' . $user->name,
            'ip_address' => request()->ip()
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->role !== 'administrator') {
            abort(403, 'Unauthorized action. Only administrators can delete users.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:administrator,it_security_analyst,organization_manager'],
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);

            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Updated User: ' . $user->name,
            'ip_address' => request()->ip()
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {

        if (auth()->user()->role !== 'administrator') {
            abort(403, 'Unauthorized action. Only administrators can delete users.');
        }


        if ($user->id == auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Deleted User: ' . $user->name,
            'ip_address' => request()->ip()
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle user status between active and inactive
     */
    public function toggleStatus(User $user)
    {
        if (auth()->user()->role !== 'administrator') {
            abort(403, 'Unauthorized action. Only administrators can change user status.');
        }

        if ($user->id == auth()->id()) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        // Toggle status
        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'Changed User Status: ' . $user->name . ' to ' . $newStatus,
            'ip_address' => request()->ip()
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User status updated to ' . $newStatus . '.');
    }
}
