<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\MockStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    public const CATEGORIES = ['Audio-Visual', 'Computing', 'Media', 'Sports'];
    public const CONDITIONS = ['Excellent', 'Good', 'Fair', 'Needs Repair'];
    public const STATUSES   = ['Available', 'Limited', 'Unavailable'];

    public function index(Request $request): View
    {
        $all = collect(MockStore::all('equipment'));
        $q   = trim((string) $request->query('q'));
        $cat = $request->query('cat', 'All');
        $st  = $request->query('status', 'All');

        $equipment = $all
            ->when($cat !== 'All', fn ($c) => $c->where('category', $cat))
            ->when($st !== 'All', fn ($c) => $c->where('status', $st))
            ->filter(fn ($e) => $q === '' || str_contains(strtolower($e['name']), strtolower($q)))
            ->values();

        return view('admin.equipment', [
            'equipment' => $equipment, 'q' => $q, 'cat' => $cat, 'st' => $st,
            'filterCategories' => $all->pluck('category')->unique()->prepend('All'),
            'statuses' => self::STATUSES, 'categories' => self::CATEGORIES, 'conditions' => self::CONDITIONS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        MockStore::insert('equipment', $this->validated($request));
        MockStore::log('Equipment added by Admin');

        return redirect()->route('admin.equipment.index')->with('status', 'Equipment saved');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        MockStore::find('equipment', $id);
        MockStore::update('equipment', $id, $this->validated($request));

        return redirect()->route('admin.equipment.index')->with('status', 'Equipment saved');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name'      => ['required', 'string', 'max:120'],
            'category'  => ['required', Rule::in(self::CATEGORIES)],
            'total'     => ['required', 'integer', 'min:1'],
            'available' => ['required', 'integer', 'min:0', 'lte:total'],
            'condition' => ['required', Rule::in(self::CONDITIONS)],
            'status'    => ['required', Rule::in(self::STATUSES)],
        ], [
            'name.required'      => 'Equipment Name is required',
            'total.required'     => 'Total Quantity is required',
            'total.min'          => 'Must be at least 1',
            'available.required' => 'Available Quantity is required',
            'available.lte'      => 'Available cannot exceed total',
        ]);
        $data['total']     = (int) $data['total'];
        $data['available'] = (int) $data['available'];

        return $data;
    }
}
