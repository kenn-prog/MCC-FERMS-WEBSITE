<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Support\MockStore;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EquipmentController extends Controller
{
    public function index(Request $request): View
    {
        $all = collect(MockStore::all('equipment'));
        $q   = trim((string) $request->query('q'));
        $cat = $request->query('cat', 'All');

        $equipment = $all
            ->when($cat !== 'All', fn ($c) => $c->where('category', $cat))
            ->filter(fn ($e) => $q === '' || str_contains(strtolower($e['name']), strtolower($q)))
            ->values();

        return view('student.equipment', [
            'equipment'  => $equipment,
            'categories' => $all->pluck('category')->unique()->prepend('All'),
            'q' => $q, 'cat' => $cat,
        ]);
    }
}
