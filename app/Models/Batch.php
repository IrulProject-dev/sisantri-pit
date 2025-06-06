<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'entry_date',
        'graduation_date',
    ];

    public function Users()
    {
        return $this->hasMany(User::class, 'batch_id');
    }
}
