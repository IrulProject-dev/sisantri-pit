<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'division_id'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }


    public function components()
    {
        return $this->belongsToMany(
            AssessmentComponent::class,
            'assessment_template_components',
            'assessment_template_id',
            'assessment_component_id'
        )->withPivot('weight');
    }
}
