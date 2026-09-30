<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Support\MockStore;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $mine       = MockStore::myReservations();
        $facilities = collect(MockStore::all('facilities'));
        $equipment  = collect(MockStore::all('equipment'));

        return view('student.dashboard', [
            'upcoming'       => $mine->where('status', 'Approved'),
            'pending'        => $mine->where('status', 'Pending')->count(),
            'availableFac'   => $facilities->where('status', 'Available'),
            'availableEq'    => $equipment->where('available', '>', 0),
            'availableUnits' => $equipment->sum('available'),
            'notifications'  => collect(MockStore::all('notifications'))->take(3),
        ]);
    }
}
