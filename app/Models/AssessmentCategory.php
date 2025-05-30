<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentCategory extends Model
{
     use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public function components()
    {
        return $this->hasMany(AssessmentComponent::class);
    }
}
