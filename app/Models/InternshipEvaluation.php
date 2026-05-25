<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipEvaluation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'internship_id', 'criteria_id', 'score'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
