<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CaseModel;
use App\Models\User;

class Negotiation extends Model
{
    use HasFactory;

    protected $primaryKey = 'negotiation_id';

    protected $fillable = [
        'case_id',
        'negotiator_id',         // References the logged-in user
        'negotiation_method',
        'subject',
        'initiation_datetime',
        'follow_up_date',
        'follow_up_actions',
        'final_resolution_date',
        'additional_comments',
        'notes',
        'outcome',
        'complainant_response',
    ];

      // Relationship: A Negotiation belongs to a Case
      public function caseRecord()
      {
          return $this->belongsTo(CaseModel::class, 'case_id');
      }
  
      // Relationship: A Negotiation is initiated by a Negotiator (User)
      public function negotiator()
      {
          return $this->belongsTo(User::class, 'negotiator_id');
      }
  
      // Relationship: A Negotiation can have multiple attachments
      public function attachments()
      {
          return $this->hasMany(NegotiationAttachment::class, 'negotiation_id');
      }

    
}
