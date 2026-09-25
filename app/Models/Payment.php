<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
        'payment_plan_id',
        'installment_number',
        'amount',
        'payment_date',
        'reference_number',
        'type', // 'total' o 'parcial'
        'status', // 'pending' o 'paid'
        'receipt_image', // Para la digitalización del comprobante
    ];

    protected $casts = [
        'amount' => 'decimal:2', // Importante para no perder centavos
        'payment_date' => 'date',
    ];
  public function paymentPlan()
    {
        return $this->belongsTo(PaymentPlan::class);
    }
}
