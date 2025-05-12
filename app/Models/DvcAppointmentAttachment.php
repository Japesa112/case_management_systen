<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DvcAppointmentAttachment extends Model
{
    use HasFactory;

    protected $table = 'dvc_appointment_attachment';
    protected $primaryKey = 'attachment_id';

    protected $fillable = [
        'appointment_id',
        'file_name',
        'file_path',
        'file_type',
        'upload_date',
    ];

    public $timestamps = true;

   

    // Optional: if you want to track which appointment it’s related to (only if appointment_id is added)
    public function appointment()
    {
        return $this->belongsTo(DvcAppointment::class, 'appointment_id');
    }
}