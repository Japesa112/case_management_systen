<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WitnessAttachment extends Model
{
    use HasFactory;

    protected $table = 'witnesses_attachments';
    protected $primaryKey = 'attachment_id';
    public $timestamps = true;

    protected $fillable = [
        'witness_id',
        'file_name',
        'file_path',
        'file_type',
        'upload_date',
    ];

    // Relationship: Each attachment belongs to a Witness
    public function witness()
    {
        return $this->belongsTo(Witness::class, 'witness_id', 'witness_id');
    }
}
