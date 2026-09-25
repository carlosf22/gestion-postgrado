<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    //
     protected $fillable = [
        'student_id',
        'course_id',
        'status',
        'enrollment_date',
    ];

    protected $casts = [
        'enrollment_date' => 'date', // Para que Laravel lo trate como fecha
    ];

    // Relaciones
    public function student() { return $this->belongsTo(Student::class); }
    public function course() { return $this->belongsTo(Course::class); }
    public function paymentPlan() { return $this->hasOne(PaymentPlan::class); }
}
