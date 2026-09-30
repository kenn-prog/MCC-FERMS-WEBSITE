<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * MCC-FERMS tables. Run after Laravel's default users migration.
 * Not used yet: the interface currently reads from App\Support\MockStore.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->string('student_id')->nullable()->unique();
            $t->string('type')->default('Student');
            $t->string('organization')->nullable();
            $t->string('role')->default('Student');
            $t->string('course')->nullable();
            $t->string('year_section')->nullable();
            $t->string('department')->nullable();
        });

        Schema::create('facilities', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('category');
            $t->string('location');
            $t->unsignedInteger('capacity');
            $t->string('status')->default('Available');
            $t->text('description')->nullable();
            $t->timestamps();
        });

        Schema::create('equipment', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('category');
            $t->unsignedInteger('total');
            $t->unsignedInteger('available');
            $t->string('condition')->default('Good');
            $t->string('status')->default('Available');
            $t->timestamps();
        });

        Schema::create('reservations', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('facility_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('equipment_id')->nullable()->constrained('equipment')->nullOnDelete();
            $t->unsignedInteger('quantity')->nullable();
            $t->date('date');
            $t->string('time_slot');
            $t->text('purpose');
            $t->string('organization')->nullable();
            $t->string('status')->default('Pending');
            $t->timestamps();
            $t->index(['status', 'date']);
        });

        Schema::create('inbox_messages', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('icon', 8)->default('i');
            $t->string('title');
            $t->text('message');
            $t->timestamp('read_at')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inbox_messages');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('equipment');
        Schema::dropIfExists('facilities');
        Schema::table('users', function (Blueprint $t) {
            $t->dropColumn(['student_id', 'type', 'organization', 'role', 'course', 'year_section', 'department']);
        });
    }
};
