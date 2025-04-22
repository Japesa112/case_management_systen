<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrialPreparationAttachment extends Model
{
    use HasFactory;

    protected $table = 'trial_preparation_attachments';

    protected $primaryKey = 'attachment_id';

    protected $fillable = [
        'preparation_id',
        'file_name',
        'file_path',
        'file_type',
        'upload_date'
        
    ];

    /**
     * Get the trial preparation that this attachment belongs to.
     */
    public function trialPreparation()
    {
        return $this->belongsTo(TrialPreparation::class, 'preparation_id');
    }

    public function attachments()
    {
        return $this->hasMany(TrialPreparationAttachment::class, 'attachment_id', 'attachment_id');
    }
}
