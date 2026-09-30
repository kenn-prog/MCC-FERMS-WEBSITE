<?php

return [
    'name'         => 'MCC-FERMS',
    'full_name'    => 'Facility Equipment Reservation Management System',
    'school'       => 'Mabalacat City College',
    'email_domain' => 'mcc.edu.ph',

    // Optional fixed "today" (Y-m-d) so the demo calendar matches the seeded data.
    'today' => env('FERMS_TODAY', '2026-09-30'),

    'time_slots' => ['8:00 AM – 12:00 PM', '1:00 PM – 5:00 PM', '8:00 AM – 5:00 PM'],

    // Sidebar navigation: [icon, label, route name, active pattern]
    'nav' => [
        'student' => [
            ['dash',  'Dashboard',    'student.dashboard',           'student.dashboard'],
            ['fac',   'Facilities',   'student.facilities.index',    'student.facilities.*'],
            ['eq',    'Equipment',    'student.equipment.index',     'student.equipment.*'],
            ['sched', 'Schedule',     'student.schedule',            'student.schedule'],
            ['res',   'Reservations', 'student.reservations.index',  'student.reservations.*'],
            ['inbox', 'Inbox',        'student.inbox.index',         'student.inbox.*'],
            ['prof',  'Profile',      'student.profile.show',        'student.profile.*'],
        ],
        'admin' => [
            ['dash',  'Dashboard',  'admin.dashboard',        'admin.dashboard'],
            ['fac',   'Facilities', 'admin.facilities.index', 'admin.facilities.*'],
            ['eq',    'Equipment',  'admin.equipment.index',  'admin.equipment.*'],
            ['req',   'Requests',   'admin.requests.index',   'admin.requests.*'],
            ['users', 'Users',      'admin.users.index',      'admin.users.*'],
            ['set',   'Settings',   'admin.settings.show',    'admin.settings.*'],
        ],
    ],
];
