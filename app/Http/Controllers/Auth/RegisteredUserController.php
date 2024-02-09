<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'image' => ['image'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->storeAs('public/avatars/', $imageName);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $imageName,
            'password' => Hash::make($request->password),
        ]);

        // Assign a role to the user
        $user->assignRole('learner');

        // Display toast notification
        toast('Registration Successful!', 'success');

        event(new Registered($user));

        Auth::login($user);

        // Check user's role and redirect accordingly
        if ($user->hasRole('superAdmin') || $user->hasRole('admin')) {
            return redirect()->intended('/dashboard');
        }

        if ($user->hasRole('learner')) {
            return redirect()->intended('/');
        }

        // If user's role is not recognized, redirect to login
        return redirect('/login');
    }
}