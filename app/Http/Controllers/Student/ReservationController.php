<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Support\MockStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ReservationController extends Controller
{
    private const TABS = [
        'Upcoming'             => ['Approved'],
        'Pending'              => ['Pending'],
        'Completed'            => ['Completed'],
        'Cancelled / Rejected' => ['Rejected', 'Cancelled'],
    ];

    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'Upcoming');
        abort_unless(isset(self::TABS[$tab]), 404);

        return view('student.reservations', [
            'tabs'         => array_keys(self::TABS),
            'tab'          => $tab,
            'reservations' => MockStore::myReservations()->whereIn('status', self::TABS[$tab]),
        ]);
    }

    public function store(Request $request, string $type, int $id): RedirectResponse
    {
        $item = MockStore::find($type === 'facility' ? 'facilities' : 'equipment', $id);
        $isFacility = $type === 'facility';

        $rules = [
            'date'    => ['required', 'date', 'after_or_equal:'.MockStore::today()->toDateString()],
            'time'    => ['required', Rule::in(config('ferms.time_slots'))],
            'purpose' => ['required', 'string', 'max:500'],
        ];
        if (! $isFacility) {
            $rules['quantity'] = ['required', 'integer', 'min:1', 'max:'.max(1, $item['available'])];
        }

        $data = $request->validate($rules, [
            'quantity.max' => 'Only '.($item['available'] ?? 0).' available',
            'quantity.min' => 'Must be at least 1',
        ]);

        $bookable = $isFacility
            ? in_array($item['status'], ['Available', 'Limited'], true)
            : $item['available'] > 0;
        abort_unless($bookable, 422, 'This item cannot be reserved right now.');

        $profile = MockStore::profile('student');

        MockStore::insert('reservations', [
            'who'     => $profile['name'],
            'org'     => explode(' · ', $profile['subtitle'])[0],
            'item'    => $item['name'].($isFacility ? '' : " (x{$data['quantity']})"),
            'date'    => $data['date'],
            'time'    => $data['time'],
            'purpose' => $data['purpose'],
            'status'  => 'Pending',
        ]);
        MockStore::log("{$item['name']} request submitted by {$profile['name']}");

        return redirect()->route('student.reservations.index', ['tab' => 'Pending'])
            ->with('status', 'Request submitted — awaiting approval');
    }

    public function cancel(int $id): RedirectResponse
    {
        $r = MockStore::find('reservations', $id);
        abort_unless($r['who'] === MockStore::profile('student')['name'] && $r['status'] === 'Pending', 403);

        MockStore::update('reservations', $id, ['status' => 'Cancelled']);

        return back()->with('status', 'Reservation cancelled');
    }
}
