<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCriteriaWeight extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'criteria_id', 'weight'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
