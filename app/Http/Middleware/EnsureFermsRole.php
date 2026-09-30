<?php

namespace App\Http\Middleware;

use App\Support\MockStore;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Guards the student/admin areas and shares layout data (profile, badge counts).
 * Swap the session lookup for Auth::user() when real authentication is added.
 */
class EnsureFermsRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = MockStore::user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user['role'] !== $role) {
            return redirect()->route($user['role'].'.dashboard');
        }

        View::share([
            'role'         => $role,
            'me'           => MockStore::profile($role),
            'unreadCount'  => collect(MockStore::all('notifications'))->where('read', false)->count(),
            'pendingCount' => collect(MockStore::all('reservations'))->where('status', 'Pending')->count(),
        ]);

        return $next($request);
    }
}
