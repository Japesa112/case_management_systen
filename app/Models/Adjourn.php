<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjourn extends Model
{
    use HasFactory;

    protected $table = 'adjourns'; // Explicitly define the table name

    protected $primaryKey = 'adjourns_id'; // Define the primary key

    public $timestamps = true; // Enable timestamps

    protected $fillable = [
        'case_id',
        'next_hearing_date',
        'adjourn_comments',
    ];

    /**
     * Relationship: An adjournment can have many attachments.
     */
    public function attachments()
    {
        return $this->hasMany(AdjournAttachment::class, 'adjourns_id');
    }
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }
}
