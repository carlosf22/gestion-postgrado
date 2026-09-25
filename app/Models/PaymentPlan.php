<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentPlan extends Model
{
    //
    protected $fillable = [
        'enrollment_id',
        'total_amount',
        'total_installments',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'total_installments' => 'integer',
    ];

    public function enrollment() { return $this->belongsTo(Enrollment::class); }
    public function payments() { return $this->hasMany(Payment::class); }
}
