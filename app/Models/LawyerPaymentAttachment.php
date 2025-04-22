<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerPaymentAttachment extends Model
{
    use HasFactory;

    protected $table = 'lawyer_payment_attachments';
    protected $primaryKey = 'attachment_id';

    protected $fillable = ['lawyer_payment_id', 'file_name', 'file_path', 'file_type', 'upload_date'];

    public function lawyerPayment()
    {
        return $this->belongsTo(LawyerPayment::class, 'lawyer_payment_id');
    }
}
