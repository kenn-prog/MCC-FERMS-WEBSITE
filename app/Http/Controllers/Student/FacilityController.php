<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Support\MockStore;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FacilityController extends Controller
{
    public function index(Request $request): View
    {
        $all = collect(MockStore::all('facilities'));
        $q   = trim((string) $request->query('q'));
        $cat = $request->query('cat', 'All');

        $facilities = $all
            ->when($cat !== 'All', fn ($c) => $c->where('category', $cat))
            ->filter(fn ($f) => $q === '' || str_contains(strtolower($f['name']), strtolower($q)))
            ->values();

        return view('student.facilities', [
            'facilities' => $facilities,
            'categories' => $all->pluck('category')->unique()->prepend('All'),
            'q' => $q, 'cat' => $cat,
        ]);
    }
}
