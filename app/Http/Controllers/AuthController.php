<?php

namespace App\Http\Controllers;

use App\Support\MockStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Prototype sign-in: emails starting with "admin" open the Admin area,
 * any other @mcc.edu.ph email opens the Student area.
 * Replace with Microsoft (Entra ID) / Laravel authentication later.
 */
class AuthController extends Controller
{
    public function show(): View|RedirectResponse
    {
        if ($user = MockStore::user()) {
            return redirect()->route($user['role'].'.dashboard');
        }

        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->boolean('microsoft')) {
            $email = 'maria.santos@mcc.edu.ph';
        } else {
            $data = $request->validate([
                'email'    => ['required', 'regex:/^[^@\s]+@mcc\.edu\.ph$/i'],
                'password' => ['required'],
            ], [
                'email.required' => 'Enter a valid @mcc.edu.ph email',
                'email.regex'    => 'Enter a valid @mcc.edu.ph email',
                'password.required' => 'Password is required',
            ]);
            $email = $data['email'];
        }

        $role = preg_match('/^admin/i', $email) ? 'admin' : 'student';

        $request->session()->regenerate();
        $request->session()->put('ferms.user', ['role' => $role, 'email' => $email]);

        return redirect()->route($role.'.dashboard')
            ->with('status', 'Signed in as '.MockStore::profile($role)['name']);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('ferms.user');
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
