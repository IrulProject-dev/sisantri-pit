<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Assessment;
use App\Models\AssessmentCategory;
use App\Models\AssessmentComponent;
use App\Models\AssessmentDetail;
use App\Models\AssessmentPeriod;
use App\Models\AssessmentTarget;
use App\Models\AssessmentTemplate;
use App\Models\AssessmentTemplateComponent;
use App\Models\Division;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::truncate();
        Division::truncate();
        AssessmentCategory::truncate();
        AssessmentComponent::truncate();
        AssessmentPeriod::truncate();
        AssessmentTemplate::truncate();
        AssessmentTemplateComponent::truncate();
        Assessment::truncate();
        AssessmentDetail::truncate();
        AssessmentTarget::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([
            DivisionSeeder::class,
            BatchSeeder::class,
            UserSeeder::class,
            AttendanceSessionSeeder::class,
        ]);

        $santri = \App\Models\User::where('role', 'santri')->first();
        $assessor = \App\Models\User::where('role', 'mentor')->first();

        $division = Division::create([
            'name' => 'IT Development',
            'description' => 'Divisi Pengembangan Teknologi'
        ]);

        // Seed assessment categories
        $softSkill = AssessmentCategory::create([
            'name' => 'Soft Skill',
            'description' => 'Keterampilan non-teknis'
        ]);

        $technicalSkill = AssessmentCategory::create([
            'name' => 'Technical Skill',
            'description' => 'Keterampilan teknis'
        ]);

        // Seed assessment components
        $communication = AssessmentComponent::create([
            'category_id' => $softSkill->id,
            'name' => 'Komunikasi',
            'max_score' => 100
        ]);

        $coding = AssessmentComponent::create([
            'category_id' => $technicalSkill->id,
            'name' => 'Coding',
            'max_score' => 100
        ]);

        // Seed assessment period
        $period = AssessmentPeriod::create([
            'name' => 'Triwulan 1 2024',
            'start_date' => now(),
            'end_date' => now()->addMonths(3),
            'is_active' => true
        ]);

        // Seed assessment template
        $template = AssessmentTemplate::create([
            'name' => 'Programmer Backend',
            'description' => 'Template untuk programmer backend',
            'division_id' => $division->id
        ]);

        // Attach components to template
        AssessmentTemplateComponent::create([
            'assessment_template_id' => $template->id,
            'assessment_component_id' => $communication->id,
            'weight' => 30.00
        ]);

        AssessmentTemplateComponent::create([
            'assessment_template_id' => $template->id,
            'assessment_component_id' => $coding->id,
            'weight' => 70.00
        ]);

        // Create assessment
        $assessment = Assessment::create([
            'santri_id' => $santri->id,
            'assessor_id' => $assessor->id,
            'assessment_template_id' => $template->id,
            'period_id' => $period->id,
            'date' => now(),
            'status' => 'submitted'
        ]);

        // Add assessment details
        AssessmentDetail::create([
            'assessment_id' => $assessment->id,
            'assessment_component_id' => $communication->id,
            'score' => 85.00
        ]);

        AssessmentDetail::create([
            'assessment_id' => $assessment->id,
            'assessment_component_id' => $coding->id,
            'score' => 90.00
        ]);

        // Create assessment target
        AssessmentTarget::create([
            'santri_id' => $santri->id,
            'assessment_component_id' => $coding->id,
            'target_score' => 95.00,
            'target_date' => now()->addMonth()
        ]);
    }
}
