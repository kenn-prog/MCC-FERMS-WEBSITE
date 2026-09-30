<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\MockStore;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $facilities   = collect(MockStore::all('facilities'));
        $equipment    = collect(MockStore::all('equipment'));
        $reservations = collect(MockStore::all('reservations'));
        $extra        = MockStore::all('dashboard');

        return view('admin.dashboard', [
            'stats' => [
                ['Total Facilities', $facilities->count(), false],
                ['Available Facilities', $facilities->where('status', 'Available')->count(), false],
                ['Available Equipment', $equipment->sum('available'), false],
                ['Pending Requests', $reservations->where('status', 'Pending')->count(), true],
                ["Today's Reservations", $extra['today_reservations'], false],
                ['Overdue Equipment', $extra['overdue_equipment'], false],
            ],
            'pending'   => $reservations->where('status', 'Pending'),
            'recent'    => $reservations->where('status', '!=', 'Pending')->take(4),
            'attention' => MockStore::all('attention'),
            'activity'  => MockStore::all('activity'),
        ]);
    }
}
