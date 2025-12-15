<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    

    public function register(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'country' => 'required|string',
                'email'   => 'required|email|unique:users,email',
                'phone'   => 'required|string|unique:users,phone',
                'password'=> 'required|string|min:6',
            ]);

            $user = User::create([
                // You may want to save country if your users table has country column
                'country' => $validatedData['country'],
                'email'    => $validatedData['email'],
                'phone'    => $validatedData['phone'],
                'password' => bcrypt($validatedData['password']),
            ]);

            return redirect()->route('login')->with('success', 'Signup Successful, please proceed to login');

        } catch (\Exception $e) {
            error_log($e->getMessage());

            // withInput() will persist user entries for old('...') in the form
            return redirect()->back()->withInput()->with('error', 'Error!'.$e->getMessage());
        }

    }

    // login functions
    public function login(Request $request){
        try {
            // Validate incoming request
            $validated = $request->validate([
                'password' => 'required|string',
                'email'    => 'nullable|email',
                'phone'    => 'nullable|string',
            ]);

            if (!empty($validated['email'])) {
                $credentials = [
                    'email' => $validated['email'],
                    'password' => $validated['password'],
                ];
            } elseif (!empty($validated['phone'])) {
                $credentials = [
                    'phone' => $validated['phone'],
                    'password' => $validated['password'],
                ];
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Please enter your email or phone number.');
            }

            // Attempt to log the user in with Auth facade
            if (Auth::attempt($credentials)) {

                $request->session()->regenerate();
                
                return redirect('/dashboard');
            }

            // If login fails, return with error
            return redirect()->back()->withInput()->with('error', 'Invalid login credentials');

        } catch (\Exception $e) {
            
            error_log($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Login error: ' . $e->getMessage());
        }
    }



    // make a logout system 
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }

}
