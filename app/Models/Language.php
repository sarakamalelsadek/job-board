<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Language extends Model
{
    use HasFactory;
    protected $guarded= [];

    //relations
    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'job_language');
    }
}
