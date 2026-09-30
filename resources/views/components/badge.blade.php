@props(['status', 'label' => null])
@php
    $class = [
        'Available' => 'g', 'Confirmed' => 'g', 'Approved' => 'g', 'Excellent' => 'g', 'Good' => 'g', 'Active' => 'g',
        'Pending' => 'a', 'Limited' => 'a', 'Fair' => 'a',
        'Rejected' => 'r', 'Unavailable' => 'r', 'Maintenance' => 'r', 'Needs Repair' => 'r', 'Overdue' => 'r', 'Cancelled' => 'r',
        'Completed' => 'gr',
    ][$status] ?? 'gr';
@endphp
<span class="badge {{ $class }}">{{ $label ?? $status }}</span>
