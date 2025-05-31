<?php
namespace Database\Seeders;

use App\Models\AttendanceSession;
use Illuminate\Database\Seeder;

class AttendanceSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attendanceSessions = [
            [
                'name'       => 'Produktif 1',
                'start_time' => '07:00:00',
                'end_time'   => '11:30:00',
            ],
            [
                'name'       => 'Produktif 2',
                'start_time' => '13:00:00',
                'end_time'   => '15:00:00',
            ],
            [
                'name'       => 'Produktif 3',
                'start_time' => '16:00:00',
                'end_time'   => '17:00:00',
            ],
            [
                'name'       => 'Produktif 4',
                'start_time' => '20:00:00',
                'end_time'   => '22:30:00',
            ],
        ];

        foreach ($attendanceSessions as $attendanceSession) {
            AttendanceSession::create($attendanceSession);
        }
    }
}
