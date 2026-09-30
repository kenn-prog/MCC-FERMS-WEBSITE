<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Support\MockStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        return view('student.profile', ['settings' => session('ferms.student_settings')]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'         => ['required', 'string', 'max:120'],
            'course'       => ['required', 'string', 'max:120'],
            'year'         => ['required', 'string', 'max:120'],
            'organization' => ['nullable', 'string', 'max:120'],
        ], [
            'name.required'   => 'Full Name is required',
            'course.required' => 'Course / Program is required',
            'year.required'   => 'Year / Section is required',
        ]);

        $data['organization'] = $data['organization'] ?? '';
        $data['initials'] = mb_strtoupper(collect(explode(' ', $data['name']))
            ->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->join(''));

        MockStore::saveProfile('student', $data);

        return back()->with('status', 'Profile updated');
    }

    public function settings(Request $request): RedirectResponse
    {
        session()->put('ferms.student_settings', [
            'email_notifications' => $request->boolean('email_notifications'),
            'return_reminders'    => $request->boolean('return_reminders'),
        ]);

        return back()->with('status', 'Settings saved');
    }
}
