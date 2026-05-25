<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'city', 'category', 'description'];

    public function evaluations()
    {
        return $this->hasMany(InternshipEvaluation::class);
    }
}
