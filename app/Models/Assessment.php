<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'santri_id',
        'assessor_id',
        'assessment_template_id',
        'period_id',
        'date',
        'note',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'status' => 'string'
    ];

    public function santri()
    {
        return $this->belongsTo(User::class, 'santri_id');
    }

    public function assessor()
    {
        return $this->belongsTo(User::class, 'assessor_id');
    }

    public function template()
    {
        return $this->belongsTo(AssessmentTemplate::class, 'assessment_template_id');
    }

    public function period()
    {
        return $this->belongsTo(AssessmentPeriod::class);
    }

    public function details()
    {
        return $this->hasMany(AssessmentDetail::class);
    }
}
