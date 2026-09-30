<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\MockStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RequestController extends Controller
{
    private const TABS = ['Pending', 'Approved', 'Rejected', 'Completed'];

    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'Pending');
        abort_unless(in_array($tab, self::TABS, true), 404);
        $q = trim((string) $request->query('q'));

        $all = collect(MockStore::all('reservations'));

        return view('admin.requests', [
            'tabs'   => self::TABS,
            'counts' => $all->countBy('status'),
            'tab' => $tab, 'q' => $q,
            'requests' => $all->where('status', $tab)
                ->filter(fn ($r) => $q === '' || str_contains(strtolower($r['who'].$r['item']), strtolower($q)))
                ->values(),
        ]);
    }

    public function decide(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate(['decision' => ['required', Rule::in(['Approved', 'Rejected'])]]);
        $r = MockStore::find('reservations', $id);
        abort_unless($r['status'] === 'Pending', 409, 'Only pending requests can be decided.');

        MockStore::update('reservations', $id, ['status' => $data['decision']]);
        MockStore::log("Admin ".strtolower($data['decision'])." {$r['item']} for {$r['who']}");

        // Notify the student inbox (only the demo student has one for now).
        if ($r['who'] === MockStore::profile('student')['name']) {
            MockStore::insert('notifications', [
                'icon'    => $data['decision'] === 'Approved' ? '✓' : '✕',
                'title'   => 'Reservation '.$data['decision'],
                'message' => "Your {$r['item']} request on ".\Carbon\Carbon::parse($r['date'])->format('M j').' was '.strtolower($data['decision']).'.',
                'when'    => 'Just now',
                'read'    => false,
            ]);
        }

        return back()->with('status', 'Request '.strtolower($data['decision']));
    }
}
