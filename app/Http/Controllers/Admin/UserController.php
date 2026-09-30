<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\MockStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public const TYPES = ['Student', 'Organization', 'Staff', 'Admin'];
    public const ROLES = ['Student', 'Student Org', 'Staff', 'Administrator'];

    public function index(Request $request): View
    {
        $q    = trim((string) $request->query('q'));
        $type = $request->query('type', 'All');

        $users = collect(MockStore::all('users'))
            ->when($type !== 'All', fn ($c) => $c->where('type', $type))
            ->filter(fn ($u) => $q === '' || str_contains(strtolower($u['name'].$u['email'].$u['student_id']), strtolower($q)))
            ->values();

        return view('admin.users', ['users' => $users, 'q' => $q, 'type' => $type, 'types' => self::TYPES, 'roles' => self::ROLES]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'         => ['required', 'string', 'max:120'],
            'student_id'   => ['required', 'string', 'max:40'],
            'type'         => ['required', Rule::in(self::TYPES)],
            'organization' => ['required', 'string', 'max:120'],
            'email'        => ['required', 'regex:/^[^@\s]+@mcc\.edu\.ph$/i'],
            'role'         => ['required', Rule::in(self::ROLES)],
        ], [
            'name.required'         => 'Full Name is required',
            'student_id.required'   => 'ID Number is required',
            'organization.required' => 'Organization / Class is required',
            'email.required'        => 'MCC Email is required',
            'email.regex'           => 'Use an @mcc.edu.ph address',
        ]);

        MockStore::insert('users', $data);
        MockStore::log("New user added: {$data['name']}");

        return redirect()->route('admin.users.index')->with('status', 'User added (demo only)');
    }
}
