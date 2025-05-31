<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First create the attendance_status enum type if using PostgreSQL
        // DB::statement("CREATE TYPE attendance_status AS ENUM ('hadir', 'izin', 'sakit', 'terlambat', 'piket')");
<<<<<<< HEAD:database/migrations/2025_04_22_074558_create_attendance_records_table.php
=======
        // First create the attendance_status enum type if using PostgreSQL and it doesn't exist
        if (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement("
                DO $$
                BEGIN
                    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'attendance_status') THEN
                        CREATE TYPE attendance_status AS ENUM ('hadir', 'izin', 'sakit', 'alfa', 'terlambat', 'piket');
                    END IF;
                END$$;
            ");
        }
>>>>>>> 7b749fdbe9e7fa1c5e85565f5a0037d48e72dc5d:database/migrations/2025_04_22_074558_create_attendances_table.php

        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('attendance_session_id')->constrained()->onDelete('cascade');
            $table->date('date');

            // For PostgreSQL, use the custom type
            if (DB::connection()->getDriverName() === 'pgsql') {
                $table->enum('status', ['hadir', 'izin', 'sakit', 'alfa', 'terlambat', 'piket'])->nullable(false);
            } else {
                // For MySQL or other databases, use regular enum
                $table->enum('status', ['hadir', 'izin', 'sakit', 'alfa', 'terlambat', 'piket'])->nullable(false);
            }

            $table->string('notes')->nullable();
            $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');

        // Drop the custom type if using PostgreSQL
        if (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement('DROP TYPE IF EXISTS attendance_status');
        }
    }
};
