<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreTrial extends Model
{
    use HasFactory;

    protected $primaryKey = 'pretrial_id';

    protected $fillable = [
        'case_id',
        'pretrial_date',
        'pretrial_time',
        'comments',
        'location',
    ];

    // Relationships
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }

    public function members()
    {
        return $this->hasMany(PreTrialMember::class, 'pretrial_id');
    }

    public function attachments()
{
    return $this->hasMany(PreTrialAttachment::class, 'pretrial_id', 'pretrial_id');
}

}