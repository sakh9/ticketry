<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
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
        $organizer = Auth::guard('organizer')->user();
        return view('organizer.profile.edit', compact('organizer'));
    }

    /**
     * Update organizer profile
     */
    public function update(Request $request): RedirectResponse
    {
        $organizerId = Auth::guard('organizer')->id();

        $request->validate([
            'nama_organizer' => 'required|string|max:255',
            'nama_penanggungjawab' => 'required|string|max:255',
            'no_hp_organizer' => 'required|string|max:20',
            'deskripsi_organizer' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'logo_organizer' => 'nullable|image|max:2048',
            'bank_code' => 'nullable|string|size:3',                    
            'bank_account_number' => 'nullable|string|max:20',         
            'bank_account_name' => 'nullable|string|max:255',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
            'instagram' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
        ]);

        $updateData = [
            'nama_organizer' => $request->nama_organizer,
            'nama_penanggungjawab' => $request->nama_penanggungjawab,
            'no_hp_organizer' => $request->no_hp_organizer,
            'deskripsi_organizer' => $request->deskripsi_organizer,
            'bank_code' => $request->bank_code,                        
            'bank_name' => config("banks.codes.{$request->bank_code}"), 
            'bank_account_number' => $request->bank_account_number,     
            'bank_account_name' => $request->bank_account_name,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'category_id' => $request->category_id,
        ];

        if ($request->hasFile('logo_organizer')) {
            $organizer = Auth::guard('organizer')->user();
            if ($organizer->logo_organizer) {
                Storage::disk('public')->delete($organizer->logo_organizer);
            }
            $updateData['logo_organizer'] = $request->file('logo_organizer')->store('logos', 'public');
        }

        if ($request->filled('current_password')) {
            $organizer = Auth::guard('organizer')->user();
            if (!Hash::check($request->current_password, $organizer->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $updateData['password'] = Hash::make($request->new_password);
        }

        Organizer::where('id_organizer', $organizerId)->update($updateData);

        return redirect()->route('organizer.profile.edit')
                        ->with('success', 'Profile updated successfully!');
    }
}