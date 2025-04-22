<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  Illuminate\Database\Eloquent\Relations\BelongsTo;
class LawyerPayment extends Model
{
    use HasFactory;

    protected $table = 'lawyer_payments';
    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'case_id', 'amount_paid', 'payment_method', 'lawyer_id',
        'transaction', 'payment_date', 'lawyer_payment_status'
    ];

    public function attachments()
    {
        return $this->hasMany(LawyerPaymentAttachment::class, 'lawyer_payment_id');
    }

    public function lawyer()
{
    return $this->belongsTo(Lawyer::class, 'lawyer_id'); // Make sure lawyer_id exists in LawyerPayment table
}

public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }

}
