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
        'case_id', 'amount_paid', 'payment_method', 'transaction',
        'payment_date',  'auctioneer_involvement'
    ];

    public function attachments()
    {
        return $this->hasMany(PaymentAttachment::class, 'payment_id');
    }
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }
}
