<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        'santri_id',
        'assessment_component_id',
        'target_score',
        'target_date',
        'notes'
    ];

    protected $casts = [
        'target_date' => 'date'
    ];

    public function santri()
    {
        return $this->belongsTo(User::class, 'santri_id');
    }

    public function component()
    {
        return $this->belongsTo(AssessmentComponent::class, 'assessment_component_id');
    }
}
