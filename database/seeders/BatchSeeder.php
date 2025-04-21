<?php
namespace Database\Seeders;

use App\Models\Batch;
use Illuminate\Database\Seeder;

class BatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create batches for the last 5 years
        $currentYear = date('Y');

        for ($i = 0; $i < 5; $i++) {
            $year = $currentYear - $i;

            Batch::create([
                'name'            => "Batch {$year}",
                'entry_date'      => "{$year}-07-15",      // July 15 of that year
                'graduation_date' => $year + 3 . "-06-30", // June 30 3 years later
            ]);
        }
    }
}
