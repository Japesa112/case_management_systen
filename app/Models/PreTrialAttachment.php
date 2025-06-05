<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreTrialAttachment extends Model
{
    use HasFactory;

    protected $primaryKey = 'attachment_id';

    protected $fillable = [
        'pretrial_id',
        'file_name',
        'file_path',
        'file_type',
        'upload_date',
    ];

    public $timestamps = true;

    // Relationships
    

    public function pretrial()
{
    return $this->belongsTo(PreTrial::class, 'pretrial_id', 'pretrial_id');
}

}
