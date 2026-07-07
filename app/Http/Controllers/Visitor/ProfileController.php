<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show profile edit form
     */
    public function edit(): View
    {
        $visitor = Auth::guard('visitor')->user();
        return view('visitor.profile.edit', compact('visitor'));
    }

    /**
     * Update visitor profile
     */
    public function update(Request $request): RedirectResponse
    {
        $visitorId = Auth::guard('visitor')->id();

        $request->validate([
            'nama_visitor' => 'required|string|max:255',
            'no_hp_visitor' => 'required|string|max:20',
            'foto_visitor' => 'nullable|image|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $updateData = [
            'nama_visitor' => $request->nama_visitor,
            'no_hp_visitor' => $request->no_hp_visitor,
        ];

        // Handle photo upload
        if ($request->hasFile('foto_visitor')) {
            $visitor = Auth::guard('visitor')->user();
            if ($visitor->foto_visitor) {
                Storage::disk('public')->delete($visitor->foto_visitor);
            }
            $updateData['foto_visitor'] = $request->file('foto_visitor')->store('photos', 'public');
        }

        // Handle password change
        if ($request->filled('current_password')) {
            $visitor = Auth::guard('visitor')->user();
            if (!Hash::check($request->current_password, $visitor->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $updateData['password'] = Hash::make($request->new_password);
        }

        Visitor::where('id_visitor', $visitorId)->update($updateData);

        return redirect()->route('visitor.profile.edit')
                        ->with('success', 'Profile updated successfully!');
    }
}