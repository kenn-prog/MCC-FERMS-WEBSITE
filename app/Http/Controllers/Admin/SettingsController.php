<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Setting definitions per tab: [label, description, type, options|default, default].
     * type: toggle | select | text | badge
     */
    public static function definitions(): array
    {
        return [
            'General' => [
                ['System Name', '', 'text', 'MCC-FERMS'],
                ['School / Organization Name', '', 'text', 'Mabalacat City College'],
                ['Time Zone', '', 'select', ['Asia/Manila (UTC+8)', 'UTC'], 'Asia/Manila (UTC+8)'],
                ['Date Format', '', 'select', ['MMM D, YYYY', 'DD/MM/YYYY', 'YYYY-MM-DD'], 'MMM D, YYYY'],
                ['Time Format', '', 'select', ['12-hour', '24-hour'], '12-hour'],
            ],
            'Reservation' => [
                ['Require approval', 'All reservations need admin approval', 'toggle', true],
                ['Minimum notice', '', 'select', ['1 day', '2 days', '3 days', '1 week'], '2 days'],
                ['Maximum duration', '', 'select', ['2 hours', '4 hours', '8 hours', '1 day'], '8 hours'],
                ['Allow overlapping reservations', 'Same facility, same time slot', 'toggle', false],
                ['Cancellation rule', '', 'select', ['Anytime before start', '24 hours before', '48 hours before'], '24 hours before'],
            ],
            'Equipment' => [
                ['Default equipment status', '', 'select', ['Available', 'Limited', 'Unavailable'], 'Available'],
                ['Borrowing rules', 'Requires approved request and ID', 'toggle', true],
                ['Default return period', '', 'select', ['Same day', '1 day', '3 days', '1 week'], 'Same day'],
                ['Overdue handling', '', 'select', ['Send reminder', 'Restrict new requests', 'Notify admin'], 'Restrict new requests'],
                ['Condition options', '', 'text', 'Excellent, Good, Fair, Needs Repair'],
            ],
            'Notifications' => [
                ['Reservation approval', '', 'toggle', true],
                ['Reservation rejection', '', 'toggle', true],
                ['Equipment request updates', '', 'toggle', true],
                ['Return reminders', '', 'toggle', true],
                ['Overdue reminders', '', 'toggle', false],
            ],
            'User & Access' => [
                ['User roles', 'Student, Student Org, Staff, Administrator', 'badge', '4 roles'],
                ['Role permissions', '', 'select', ['Student — reserve only', 'Staff — manage inventory', 'Administrator — full access'], 'Student — reserve only'],
                ['Authorized MCC accounts', 'Only @mcc.edu.ph Microsoft accounts', 'text', '@mcc.edu.ph'],
                ['Staff / Admin access', 'Allow staff to approve requests', 'toggle', true],
            ],
            'System Info' => null,
        ];
    }

    public function show(Request $request): View
    {
        $defs = static::definitions();
        $tab  = $request->query('tab', 'General');
        abort_unless(array_key_exists($tab, $defs), 404);

        return view('admin.settings', [
            'tabs'  => array_keys($defs),
            'tab'   => $tab,
            'items' => $defs[$tab],
            'saved' => session("ferms.settings.$tab", []),
        ]);
    }

    public function update(Request $request, string $tab): RedirectResponse
    {
        $defs = static::definitions();
        abort_unless(isset($defs[$tab]), 404);

        $values = [];
        foreach ($defs[$tab] as $item) {
            [$label, , $type] = $item;
            $slug = Str::slug($label, '_');
            if ($type === 'toggle') {
                $values[$slug] = $request->boolean("s.$slug");
            } elseif ($type === 'select' || $type === 'text') {
                $values[$slug] = (string) $request->input("s.$slug", '');
            }
        }
        session()->put("ferms.settings.$tab", $values);

        return redirect()->route('admin.settings.show', ['tab' => $tab])->with('status', 'Settings saved');
    }
}
