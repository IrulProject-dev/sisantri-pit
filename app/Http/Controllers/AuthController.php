<?php
namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PDOException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        try {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        } catch (QueryException $e) {
            // Handle database query exceptions
            return back()->withErrors([
                'database' => 'Unable to connect to the database. Please try again later or contact support.',
            ])->withInput($request->except('password'));
        } catch (PDOException $e) {
            // Handle PDO exceptions (more specific database connection issues)
            return back()->withErrors([
                'database' => 'Database connection failed. Please try again later or contact support.',
            ])->withInput($request->except('password'));
        } catch (Exception $e) {
            // Handle any other unexpected exceptions
            return back()->withErrors([
                'error' => 'An unexpected error occurred. Please try again later.',
            ])->withInput($request->except('password'));
        }
    }

    public function showRegistrationForm()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
