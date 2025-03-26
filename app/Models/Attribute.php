<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'options' => 'array', 
    ];

    //type consts 'text', 'number', 'boolean', 'date', 'select'
    const TYPE_TEXT = 'text';
    const TYPE_NUMBER = 'number';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_DATE = 'date';
    const TYPE_SELECT = 'select';

    
    //relations
    public function jobAttributeValues(): HasMany
    {
        return $this->hasMany(JobAttributeValue::class);
    }
}
