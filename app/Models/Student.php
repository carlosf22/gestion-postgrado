<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $fillable = [
        'ci',
        'first_name',
        'last_name',
        'mother_last_name',
        'phone',
        'registration_number',
        'discount',
    ];

    protected $casts = [
        'discount' => 'decimal:2', // Lo trata como número con 2 decimales
        'created_at' => 'datetime', // Lo trata como objeto de fecha/hora
        'updated_at' => 'datetime',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function documents()
    {
        return $this->hasMany(Documents::class);
    }

    public function fullName()
    {
        return trim(implode(' ', array_filter([
            $this->first_name,
            $this->last_name,
            $this->mother_last_name,
        ])));
    }
}
