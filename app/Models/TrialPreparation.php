<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class TrialPreparation extends Model
{
    use HasFactory;

    protected $table = 'trial_preparations';

    protected $primaryKey = 'preparation_id';

    protected $fillable = ['case_id', 'preparation_date','preparation_time', 'briefing_notes', 'preparation_status'];


    /**
     * Get the case that this trial preparation belongs to.
     */
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }

    /**
     * Get the lawyer that this trial preparation belongs to.
     */
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id');
    }

    public function lawyers(): BelongsToMany
    {
        return $this->belongsToMany(Lawyer::class, 'trial_preparation_lawyer', 'preparation_id', 'lawyer_id')
                    ->withTimestamps();
    }


    public function attachments()
    {
        return $this->hasMany(TrialPreparationAttachment::class, 'preparation_id', 'preparation_id');
    }
}
