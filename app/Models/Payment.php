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
        'payee',            // e.g., 'complainant', 'lawyer', 'kenyatta_university', 'other'
        'payee_id',         // nullable, used only if payee is 'complainant' or 'lawyer'
        'amount_paid',
        'payment_method',
        'transaction',
        'payment_date',
        'payment_time',
        'due_date',
        'due_time',
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
        return $this->belongsTo(Complainant::class, 'payee_id')->where('payee', 'complainant');
    }

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'payee_id')->where('payee', 'lawyer');
    }
}
