<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'max_score'
    ];

    public function category()
    {
        return $this->belongsTo(AssessmentCategory::class);
    }

    public function templates()
    {
        return $this->belongsToMany(
            AssessmentTemplate::class,
            'assessment_template_components',
            'assessment_component_id',
            'assessment_template_id'
        )->withPivot('weight');
    }
}
