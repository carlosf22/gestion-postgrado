<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    //
     protected $fillable = [
        'name',
        'edition',
        'version',
        'type',
        'cost', // Si decides agregar el costo aquí
        'capacity', // Cupo máximo
        'active',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'capacity' => 'integer',
        'active' => 'boolean',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function availableSlots()
    {
        $taken = $this->enrollments()
            ->where('status', '!=', 'cancelled')
            ->count();
        return max(0, $this->capacity - $taken);
    }
}
