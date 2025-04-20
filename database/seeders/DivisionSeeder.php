<?php
namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            [
                'name'        => 'Programmer',
                'description' => 'Division that focused on Web and Mobile Application Development',
            ],
            [
                'name'        => 'Multimedia',
                'description' => 'Division that focused on Design and Video Editing',
            ],
            [
                'name'        => 'Marketing',
                'description' => 'Division that focused on Digital Marketing and Advertising',
            ],
        ];

        foreach ($divisions as $division) {
            Division::create($division);
        }
    }
}
