<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminManagementController extends Controller
{
    /**
     * List all admins
     */
    public function index(): View
    {
        $admins = Admin::all();
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Create a new admin
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_admin' => 'required|string|max:255',
            'email_admin' => 'required|email|unique:admins,email_admin',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Check for duplicate admin name
        $exists = Admin::where('nama_admin', $request->nama_admin)->first();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'An admin with the name "' . $exists->nama_admin . '" already exists. Please use a different name.');
        }

        $admin = Admin::create([
            'nama_admin' => $request->nama_admin,
            'email_admin' => $request->email_admin,
            'password' => Hash::make($request->password),
        ]);

        $admin->assignRole('admin');

        return back()->with('success', 'Admin "' . $admin->nama_admin . '" created successfully.');
    }

    /**
     * Delete an admin (can't delete yourself)
     */
    public function destroy(Admin $admin): RedirectResponse
    {
        if ($admin->id_admin === Auth::guard('admin')->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $admin->delete();

        return back()->with('success', 'Admin deleted.');
    }
}