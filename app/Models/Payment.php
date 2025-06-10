<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'case_id',
        'payee',
        'payee_id',
        'amount_paid',
        'payment_method',
        'transaction',
        'payment_date',
        'payment_time',
        'due_date',
        'due_time',
        'payment_status',
        'payment_type',
        'auctioneer_involvement',
    ];

    public function attachments()
    {
        return $this->hasMany(PaymentAttachment::class, 'payment_id');
    }

    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }

    public function complainant()
    {
        return $this->belongsTo(Complainant::class, 'payee_id');
    }

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'payee_id');
    }
}

