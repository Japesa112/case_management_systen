<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NegotiationAttachment extends Model
{
    use HasFactory;
    protected $table = 'negotiation_attachments'; // Ensure correct table name
    protected $primaryKey = 'attachment_id'; // Explicitly set the primary key


    protected $fillable = [
        'negotiation_id',
        'file_name',
        'file_path',
        'file_type'
    ];

    public function negotiation()
    {
        return $this->belongsTo(Negotiation::class);
    }
}
