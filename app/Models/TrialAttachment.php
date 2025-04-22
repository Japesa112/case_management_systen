<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrialAttachment extends Model
{
    use HasFactory;

    protected $table = 'trials_attachments';

    protected $primaryKey = 'attachment_id';

    protected $fillable = [
        'trial_id',
        'file_name',
        'file_path',
        'file_type',
        'upload_date',
        
    ];

    /**
     * Get the trial that this attachment belongs to.
     */
    public function trial()
    {
        return $this->belongsTo(Trial::class, 'trial_id');
    }
}
