<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjournAttachment extends Model
{
    use HasFactory;

    protected $table = 'adjourn_attachments'; // Explicitly define the table name

    protected $primaryKey = 'attachment_id'; // Define the primary key

    public $timestamps = true; // Enable timestamps

    protected $fillable = [
        'adjourns_id',
        'file_name',
        'file_path',
        'file_type',
        'upload_date',
    ];

    /**
     * Relationship: An attachment belongs to an adjournment.
     */
    public function adjourn()
    {
        return $this->belongsTo(Adjourn::class, 'adjourns_id');
    }
}
