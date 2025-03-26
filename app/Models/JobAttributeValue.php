<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobAttributeValue extends Model
{
    use HasFactory;
    protected $guarded = [];

    //relations
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}
