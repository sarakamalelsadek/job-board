<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;
    protected $guarded=[];

    //job type consts
    const FULL_TIME = 'full-time';
    const PART_TIME = 'part-time';
    const CONTRACT = 'contract';
    const FREELANCE = 'freelance';

    //status consts
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_ARCHIVED = 'archived';

    //relations
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'job_language');
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'job_location');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'job_category');
    }

    public function jobAttributeValues(): HasMany
    {
        return $this->hasMany(JobAttributeValue::class);
    }

    public function attributes()
{
    return $this->hasManyThrough(
        Attribute::class, 
        JobAttributeValue::class,
        'job_id',      // المفتاح الأجنبي في `job_attribute_values`
        'id',          // المفتاح الأساسي في `attributes`
        'id',          // المفتاح الأساسي في `jobs`
        'attribute_id' // المفتاح الأجنبي في `job_attribute_values`
    );
}
  }
