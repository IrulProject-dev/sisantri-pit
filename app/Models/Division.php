<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    public function santris()
    {
        return $this->hasMany(User::class);
    }

    public function assessmentTemplates()
    {
        return $this->hasMany(AssessmentTemplate::class);
    }
}
