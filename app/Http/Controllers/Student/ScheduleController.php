<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Support\MockStore;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function __invoke(Request $request): View
    {
        $today = MockStore::today();
        $view  = in_array($request->query('view'), ['Day', 'Week', 'Month'], true) ? $request->query('view') : 'Month';

        try {
            $sel = Carbon::parse($request->query('date', $today->toDateString()))->startOfDay();
        } catch (\Throwable) {
            $sel = $today->copy();
        }

        $bookings = MockStore::myReservations()
            ->reject(fn ($r) => in_array($r['status'], ['Rejected', 'Cancelled'], true))
            ->groupBy('date');

        $cells = collect();
        if ($view === 'Month') {
            $start = $sel->copy()->startOfMonth();
            $start = $start->copy()->subDays($start->dayOfWeek);
            $cells = collect(range(0, 41))->map(fn ($i) => $start->copy()->addDays($i));
        } elseif ($view === 'Week') {
            $start = $sel->copy()->subDays($sel->dayOfWeek);
            $cells = collect(range(0, 6))->map(fn ($i) => $start->copy()->addDays($i));
        }

        $step = match ($view) {
            'Month' => [$sel->copy()->startOfMonth()->subMonth(), $sel->copy()->startOfMonth()->addMonth()],
            'Week'  => [$sel->copy()->subWeek(), $sel->copy()->addWeek()],
            default => [$sel->copy()->subDay(), $sel->copy()->addDay()],
        };

        return view('student.schedule', [
            'view' => $view, 'sel' => $sel, 'today' => $today,
            'cells' => $cells, 'bookings' => $bookings,
            'prev' => $step[0]->toDateString(), 'next' => $step[1]->toDateString(),
        ]);
    }
}
