<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forwarding extends Model
{
    use HasFactory;

    protected $table = 'forwardings'; // Define the table name

    protected $primaryKey = 'forwarding_id'; // Set primary key

    public $timestamps = true; // Enables created_at & updated_at

    protected $fillable = [
        'case_id',
        'lawyer_id',
        'dvc_appointment_date',
        'dvc_appointment_time',
        'briefing_notes',
    ];

    // Define relationships
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id', 'case_id');
    }

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id', 'id');
    }


    public function dvcAppointment()
    {
        return $this->hasOne(DvcAppointment::class);
    }
}