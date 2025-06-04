<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreTrialMember extends Model
{
    use HasFactory;

    protected $primaryKey = 'member_id';

    protected $fillable = [
        'pretrial_id',
        'member_type',
        'name',
        'role_or_position',
    ];

    // Relationships
    public function preTrial()
    {
        return $this->belongsTo(PreTrial::class, 'pretrial_id');
    }
}