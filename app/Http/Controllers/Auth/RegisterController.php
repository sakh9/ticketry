<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        // Validate role selection first
        $request->validate([
            'role' => 'required|in:organizer,visitor',
        ]);

        // Register as Organizer
        if ($request->role === 'organizer') {
            return $this->registerOrganizer($request);
        }

        // Register as Visitor
        if ($request->role === 'visitor') {
            return $this->registerVisitor($request);
        }

        return back()->with('error', 'Please select a valid role.');
    }

    /**
     * Register a new organizer
     */
    private function registerOrganizer(Request $request)
    {
        $request->validate([
            'nama_organizer' => 'required|string|max:255',
            'nama_penanggungjawab' => 'required|string|max:255',
            'no_hp_organizer' => 'required|string|max:20',
            'email_organizer' => 'required|email|unique:organizers,email_organizer',
            'category_id' => 'required|exists:categories,id',
            'deskripsi_organizer' => 'nullable|string',
            'logo_organizer' => 'nullable|image|max:2048',
            'password' => 'required|string|min:8|confirmed',
            'bank_code' => 'nullable|string|size:3',
            'bank_account_number' => 'nullable|string|max:20',
            'bank_account_name' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
        ]);

        // Handle logo upload
        $logoPath = null;
        if ($request->hasFile('logo_organizer')) {
            $logoPath = $request->file('logo_organizer')->store('logos', 'public');
        }

        // Create organizer
        $organizer = Organizer::create([
            'nama_organizer' => $request->nama_organizer,
            'nama_penanggungjawab' => $request->nama_penanggungjawab,
            'no_hp_organizer' => $request->no_hp_organizer,
            'email_organizer' => $request->email_organizer,
            'password' => Hash::make($request->password),
            'deskripsi_organizer' => $request->deskripsi_organizer,
            'logo_organizer' => $logoPath,
            'bank_code' => $request->bank_code,
            'bank_name' => config("banks.codes.{$request->bank_code}"),
            'bank_account_number' => $request->bank_account_number,
            'bank_account_name' => $request->bank_account_name,
            'role_id' => 2,
            'category_id' => $request->category_id,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
        ]);

        Auth::guard('organizer')->login($organizer);
        
        return redirect()->route('organizer.events.index')
                        ->with('success', 'Welcome, ' . $organizer->nama_organizer . '!');
    }

    /**
     * Register a new visitor
     */
    private function registerVisitor(Request $request)
    {
        $request->validate([
            'nama_visitor' => 'required|string|max:255',
            'nik_visitor' => 'required|string|size:16|unique:visitors,nik_visitor',
            'no_hp_visitor' => 'required|string|max:20',
            'email_visitor' => 'required|email|unique:visitors,email_visitor',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create visitor
        $visitor = Visitor::create([
            'nama_visitor' => $request->nama_visitor,
            'nik_visitor' => $request->nik_visitor,
            'no_hp_visitor' => $request->no_hp_visitor,
            'email_visitor' => $request->email_visitor,
            'password' => Hash::make($request->password),
            'role_id' => 3, // Visitor role
        ]);

        Auth::guard('visitor')->login($visitor);
        
        return redirect()->route('visitor.events.index')
                        ->with('success', 'Welcome, ' . $visitor->nama_visitor . '!');
    }
}