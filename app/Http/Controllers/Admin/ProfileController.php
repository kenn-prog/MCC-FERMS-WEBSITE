<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\MockStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        return view('admin.profile');
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:120'],
            'department' => ['required', 'string', 'max:160'],
        ], [
            'name.required'       => 'Full Name is required',
            'department.required' => 'Department / Office is required',
        ]);

        $data['initials'] = mb_strtoupper(collect(explode(' ', $data['name']))
            ->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->join(''));

        MockStore::saveProfile('admin', $data);

        return back()->with('status', 'Profile updated');
    }

    public function picture(): RedirectResponse
    {
        return back()->with('status', 'Profile picture upload is simulated');
    }
}
