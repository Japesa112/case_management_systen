<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{
    use HasFactory;

    protected $table = 'appeal'; // Define table name

    protected $primaryKey = 'appeal_id'; // Set primary key

    public $timestamps = false; // Disable timestamps if not needed

    protected $fillable = [
        'case_id',
        'next_hearing_date',
        'next_hearing_time',
        'appeal_comments',
    ];

    // Define relationship with Case (assuming a Case model exists)
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }
    public function caseRecord()
      {
          return $this->belongsTo(CaseModel::class, 'case_id');
      }

      public function attachments()
    {
        return $this->hasMany(AppealAttachment::class, 'appeal_id', 'appeal_id');
    }
}
