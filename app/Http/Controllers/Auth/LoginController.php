<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Organizer;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        $organizers = Organizer::select('email_organizer as email')->get();
        $visitors = Visitor::select('email_visitor as email')->get();
        $admins = Admin::select('email_admin as email')->get();
        
        $registeredUsers = [];
        foreach ($organizers as $org) {
            $registeredUsers[] = ['email' => $org->email, 'role' => 'organizer'];
        }
        foreach ($visitors as $vis) {
            $registeredUsers[] = ['email' => $vis->email, 'role' => 'visitor'];
        }
        foreach ($admins as $adm) {
            if ($adm->email) {
                $registeredUsers[] = ['email' => $adm->email, 'role' => 'admin'];
            }
        }
        
        return view('auth.login', compact('registeredUsers'));
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;

        // Try Admin first
        $admin = Admin::where('email_admin', $email)->first();
        if ($admin && Hash::check($password, $admin->password)) {
            Auth::guard('admin')->login($admin, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // Try Organizer
        $organizer = Organizer::where('email_organizer', $email)->first();
        if ($organizer && Hash::check($password, $organizer->password)) {
            Auth::guard('organizer')->login($organizer, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('organizer.events.index'));
        }

        // Try Visitor
        $visitor = Visitor::where('email_visitor', $email)->first();
        if ($visitor && Hash::check($password, $visitor->password)) {
            Auth::guard('visitor')->login($visitor, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('visitor.events.index'));
        }

        return back()
            ->withErrors(['email' => 'Email or password is incorrect.'])
            ->withInput($request->only('email'));
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }
        if (Auth::guard('organizer')->check()) {
            Auth::guard('organizer')->logout();
        }
        if (Auth::guard('visitor')->check()) {
            Auth::guard('visitor')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}