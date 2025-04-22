<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trial extends Model
{
    use HasFactory;

    protected $table = 'trials';

    protected $primaryKey = 'trial_id';

    protected $fillable = [
        'case_id',
        'trial_date',
        'judgement_details',
        'judgement_date',
        'outcome'
    ];

    /**
     * Get the case that this trial belongs to.
     */
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }

    public function attachments()
    {
        return $this->hasMany(TrialAttachment::class, 'trial_id', 'trial_id');
    }
}
