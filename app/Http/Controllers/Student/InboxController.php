<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Support\MockStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InboxController extends Controller
{
    public function index(): View
    {
        return view('student.inbox', ['notifications' => collect(MockStore::all('notifications'))]);
    }

    public function read(int $id): RedirectResponse
    {
        MockStore::update('notifications', $id, ['read' => true]);

        return back();
    }

    public function readAll(): RedirectResponse
    {
        MockStore::put('notifications', array_map(fn ($n) => [...$n, 'read' => true], MockStore::all('notifications')));

        return back()->with('status', 'All marked as read');
    }
}
