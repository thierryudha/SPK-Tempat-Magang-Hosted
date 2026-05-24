<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriaScale extends Model
{
    use HasFactory;

    protected $fillable = ['criteria_id', 'score', 'description'];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
