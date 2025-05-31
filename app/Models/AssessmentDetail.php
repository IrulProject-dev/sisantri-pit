<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentDetail extends Model
{
     use HasFactory;

    protected $fillable = [
        'assessment_id',
        'assessment_component_id',
        'score',
        'notes'
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function component()
    {
        return $this->belongsTo(AssessmentComponent::class, 'assessment_component_id');
    }
}
