<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MooraSession extends Model
{
    protected $fillable = ['user_id', 'winner_name', 'max_optimization_value', 'criteria_used'];

    protected $casts = [
        'criteria_used' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evaluations()
    {
        return $this->hasMany(InternshipEvaluation::class);
    }
}
