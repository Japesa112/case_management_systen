<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAttachment extends Model
{
    use HasFactory;

    protected $table = 'payment_attachments';
    protected $primaryKey = 'attachment_id';

    protected $fillable = ['payment_id', 'file_name', 'file_path', 'file_type', 'upload_date'];

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
