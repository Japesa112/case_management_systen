<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DvcAppointment extends Model
{
    use HasFactory;

    protected $table = 'dvc_appointment';
    protected $primaryKey = 'appointment_id';

    protected $fillable = [
        'evaluation_id',
        'forwarding_id',
        'comments',
        'appointment_time',
        'appointment_date',
    ];

    public $timestamps = true;

    // Relationship: One appointment belongs to one evaluation
    public function evaluation()
    {
        return $this->belongsTo(PanelEvaluation::class, 'evaluation_id');
    }

    // Relationship: One appointment has many attachments
    public function attachments()
    {
        return $this->hasMany(DvcAppointmentAttachment::class, 'appointment_id');
    }

    // DVCAppointment.php
    public function forwarding()
    {
        return $this->belongsTo(Forwarding::class, 'forwarding_id', 'forwarding_id');
    }

}