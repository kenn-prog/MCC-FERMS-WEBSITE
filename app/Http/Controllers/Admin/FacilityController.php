<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\MockStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FacilityController extends Controller
{
    public const STATUSES   = ['Available', 'Limited', 'Unavailable', 'Maintenance'];
    public const CATEGORIES = ['Sports', 'Rooms', 'Labs'];

    public function index(Request $request): View
    {
        $q  = trim((string) $request->query('q'));
        $st = $request->query('status', 'All');

        $facilities = collect(MockStore::all('facilities'))
            ->when($st !== 'All', fn ($c) => $c->where('status', $st))
            ->filter(fn ($f) => $q === '' || str_contains(strtolower($f['name']), strtolower($q)))
            ->values();

        return view('admin.facilities', [
            'facilities' => $facilities, 'q' => $q, 'st' => $st,
            'statuses' => self::STATUSES, 'categories' => self::CATEGORIES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        MockStore::insert('facilities', $this->validated($request));
        MockStore::log('Facility added by Admin');

        return redirect()->route('admin.facilities.index')->with('status', 'Facility saved');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        MockStore::find('facilities', $id);
        MockStore::update('facilities', $id, $this->validated($request));

        return redirect()->route('admin.facilities.index')->with('status', 'Facility saved');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:120'],
            'location'    => ['required', 'string', 'max:160'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'category'    => ['required', Rule::in(self::CATEGORIES)],
            'status'      => ['required', Rule::in(self::STATUSES)],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'name.required'     => 'Facility Name is required',
            'location.required' => 'Location is required',
            'capacity.required' => 'Capacity is required',
            'capacity.min'      => 'Must be at least 1',
        ]);
        $data['capacity']    = (int) $data['capacity'];
        $data['description'] = $data['description'] ?? '';

        return $data;
    }
}
