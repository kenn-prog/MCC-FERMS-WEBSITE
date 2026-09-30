<?php

namespace App\Support;

/**
 * Seed data lifted from the MCC-FERMS prototype.
 * Replaced by the MySQL database (see database/migrations) once it is connected.
 */
class MockSeed
{
    public static function get(string $key): mixed
    {
        return static::data()[$key] ?? [];
    }

    public static function data(): array
    {
        return [
            'facilities' => [
                ['id' => 1, 'name' => 'Gymnasium', 'category' => 'Sports', 'location' => 'Main Campus, Ground Floor', 'capacity' => 800, 'status' => 'Available', 'description' => 'Covered court for sports events, assemblies and PE classes.'],
                ['id' => 2, 'name' => 'Audio-Visual Room', 'category' => 'Rooms', 'location' => 'Academic Bldg, 2nd Floor', 'capacity' => 120, 'status' => 'Available', 'description' => 'Tiered seating with projector, surround sound and stage.'],
                ['id' => 3, 'name' => 'Conference Room', 'category' => 'Rooms', 'location' => 'Admin Bldg, 3rd Floor', 'capacity' => 30, 'status' => 'Limited', 'description' => 'Boardroom setup for meetings and thesis panels.'],
                ['id' => 4, 'name' => 'Computer Laboratory 1', 'category' => 'Labs', 'location' => 'IT Bldg, Room 101', 'capacity' => 40, 'status' => 'Available', 'description' => '40 workstations with high-speed campus network.'],
                ['id' => 5, 'name' => 'Lecture Room 204', 'category' => 'Rooms', 'location' => 'Academic Bldg, 2nd Floor', 'capacity' => 50, 'status' => 'Unavailable', 'description' => 'Standard lecture room with whiteboard and projector mount.'],
                ['id' => 6, 'name' => 'Computer Laboratory 2', 'category' => 'Labs', 'location' => 'IT Bldg, Room 102', 'capacity' => 35, 'status' => 'Maintenance', 'description' => 'Programming lab currently under hardware upgrade.'],
            ],
            'equipment' => [
                ['id' => 1, 'name' => 'Projector', 'category' => 'Audio-Visual', 'available' => 5, 'total' => 8, 'condition' => 'Good', 'status' => 'Available'],
                ['id' => 2, 'name' => 'Laptop', 'category' => 'Computing', 'available' => 2, 'total' => 10, 'condition' => 'Good', 'status' => 'Limited'],
                ['id' => 3, 'name' => 'Wireless Microphone', 'category' => 'Audio-Visual', 'available' => 6, 'total' => 6, 'condition' => 'Excellent', 'status' => 'Available'],
                ['id' => 4, 'name' => 'Portable Speaker', 'category' => 'Audio-Visual', 'available' => 0, 'total' => 4, 'condition' => 'Fair', 'status' => 'Unavailable'],
                ['id' => 5, 'name' => 'DSLR Camera', 'category' => 'Media', 'available' => 1, 'total' => 3, 'condition' => 'Good', 'status' => 'Limited'],
                ['id' => 6, 'name' => 'Badminton Set', 'category' => 'Sports', 'available' => 9, 'total' => 12, 'condition' => 'Needs Repair', 'status' => 'Available'],
            ],
            // One list for both the student's "Reservations" and the admin's "Requests" screens.
            'reservations' => [
                ['id' => 1, 'who' => 'Maria Santos', 'org' => 'BSIT 3-A', 'item' => 'Audio-Visual Room', 'date' => '2026-10-04', 'time' => '1:00 – 4:00 PM', 'purpose' => 'Org General Assembly', 'status' => 'Approved'],
                ['id' => 2, 'who' => 'Maria Santos', 'org' => 'BSIT 3-A', 'item' => 'Projector (x1)', 'date' => '2026-10-04', 'time' => '1:00 – 4:00 PM', 'purpose' => 'General Assembly', 'status' => 'Approved'],
                ['id' => 3, 'who' => 'Maria Santos', 'org' => 'BSIT 3-A', 'item' => 'Conference Room', 'date' => '2026-10-09', 'time' => '9:00 – 11:00 AM', 'purpose' => 'Thesis consultation', 'status' => 'Pending'],
                ['id' => 4, 'who' => 'Maria Santos', 'org' => 'BSIT 3-A', 'item' => 'Gymnasium', 'date' => '2026-09-12', 'time' => '8:00 AM – 12:00 PM', 'purpose' => 'Intramurals rehearsal', 'status' => 'Completed'],
                ['id' => 5, 'who' => 'Maria Santos', 'org' => 'BSIT 3-A', 'item' => 'Computer Laboratory 1', 'date' => '2026-09-20', 'time' => '2:00 – 5:00 PM', 'purpose' => 'Programming workshop', 'status' => 'Rejected'],
                ['id' => 6, 'who' => 'Juan Dela Cruz', 'org' => 'BSCS 2-B', 'item' => 'Laptop (x2)', 'date' => '2026-10-05', 'time' => '8:00 AM – 5:00 PM', 'purpose' => 'Research data entry', 'status' => 'Pending'],
                ['id' => 7, 'who' => 'MCC Student Council', 'org' => 'Student Council', 'item' => 'Gymnasium', 'date' => '2026-10-15', 'time' => '8:00 AM – 6:00 PM', 'purpose' => 'Sports Fest', 'status' => 'Pending'],
                ['id' => 8, 'who' => 'Carlo Mendoza', 'org' => 'Media Club', 'item' => 'DSLR Camera', 'date' => '2026-09-20', 'time' => '9:00 AM – 3:00 PM', 'purpose' => 'Photo documentation', 'status' => 'Rejected'],
            ],
            'notifications' => [
                ['id' => 1, 'icon' => '✓', 'title' => 'Reservation Approved', 'message' => 'Your Audio-Visual Room reservation on Oct 4 was approved.', 'when' => '2h ago', 'read' => false],
                ['id' => 2, 'icon' => '✕', 'title' => 'Reservation Rejected', 'message' => 'Computer Laboratory 1 is unavailable on Sep 20.', 'when' => 'Yesterday', 'read' => false],
                ['id' => 3, 'icon' => '⟳', 'title' => 'Equipment Request Updated', 'message' => 'Projector (x1) is ready for pickup at the Property Office.', 'when' => 'Yesterday', 'read' => false],
                ['id' => 4, 'icon' => '⏰', 'title' => 'Return Reminder', 'message' => 'Please return the Laptop borrowed on Sep 28 by 5:00 PM.', 'when' => 'Sep 28', 'read' => true],
                ['id' => 5, 'icon' => 'i', 'title' => 'Reservation Update', 'message' => 'Conference Room schedule adjusted to 9:00 – 11:00 AM.', 'when' => 'Sep 25', 'read' => true],
            ],
            'users' => [
                ['id' => 1, 'name' => 'Maria Santos', 'student_id' => '2023-00142', 'type' => 'Student', 'organization' => 'BSIT 3-A', 'email' => 'maria.santos@mcc.edu.ph', 'role' => 'Student'],
                ['id' => 2, 'name' => 'Juan Dela Cruz', 'student_id' => '2024-00311', 'type' => 'Student', 'organization' => 'BSCS 2-B', 'email' => 'juan.delacruz@mcc.edu.ph', 'role' => 'Student'],
                ['id' => 3, 'name' => 'IT Society', 'student_id' => 'ORG-014', 'type' => 'Organization', 'organization' => 'CCS', 'email' => 'itsociety@mcc.edu.ph', 'role' => 'Student Org'],
                ['id' => 4, 'name' => 'MCC Student Council', 'student_id' => 'ORG-001', 'type' => 'Organization', 'organization' => 'SSC', 'email' => 'ssc@mcc.edu.ph', 'role' => 'Student Org'],
                ['id' => 5, 'name' => 'Ramon Dizon', 'student_id' => 'EMP-0021', 'type' => 'Staff', 'organization' => 'Property Office', 'email' => 'r.dizon@mcc.edu.ph', 'role' => 'Staff'],
                ['id' => 6, 'name' => 'Admin Name', 'student_id' => 'EMP-0001', 'type' => 'Admin', 'organization' => 'Office of the Administrator', 'email' => 'admin@mcc.edu.ph', 'role' => 'Administrator'],
            ],
            'activity' => [
                'Admin approved Audio-Visual Room for IT Society — 10:42 AM',
                'Laptop (x2) request submitted by Juan Dela Cruz — 9:15 AM',
                'Computer Laboratory 2 marked Maintenance — Yesterday',
                'New user added: Ramon Dizon — Sep 28',
            ],
            'attention' => [
                ['name' => 'Portable Speaker', 'why' => 'Fair condition · 0 available'],
                ['name' => 'Badminton Set', 'why' => 'Needs repair'],
                ['name' => 'Laptop #7', 'why' => 'Overdue by 2 days'],
            ],
            'dashboard' => ['today_reservations' => 3, 'overdue_equipment' => 1],
            'profiles' => [
                'student' => ['name' => 'Maria Santos', 'initials' => 'MS', 'subtitle' => 'BSIT 3-A · Student', 'student_id' => '2023-00142', 'email' => 'maria.santos@mcc.edu.ph', 'course' => 'BS Information Technology', 'year' => '3rd Year — Section A', 'organization' => 'IT Society'],
                'admin'   => ['name' => 'Admin Name', 'initials' => 'AN', 'subtitle' => 'School Administrator', 'student_id' => 'EMP-0001', 'email' => 'admin@mcc.edu.ph', 'department' => 'Office of the Administrator', 'role' => 'School Administrator'],
            ],
        ];
    }
}
