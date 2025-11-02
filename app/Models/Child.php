<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'child_number',
        'first_name',
        'last_name',
        'class_name',
        'teacher_name',
        'date_of_birth',
    ];

    protected $casts = [
        'child_number' => 'integer',
        'date_of_birth' => 'date',
    ];

    /**
     * Get the registration that owns this child
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Get the full name attribute
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}

