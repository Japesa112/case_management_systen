<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseActivity extends Model
{
    use HasFactory;

    // Table name (optional if it's default plural form)
    protected $table = 'case_activities';

    // Primary key (optional if it's 'id')
    protected $primaryKey = 'id';

    // Auto-incrementing (optional for non-numeric keys)
    public $incrementing = true;

    // Fillable fields (for mass-assignment)
    protected $fillable = [
        'case_id',
        'type',
        'sequence_number',
        'court_room_number',
        'court_name',
        'time',
        'date',
        'hearing_type',
        'virtual_link',
        'court_contacts'
    ];

    // Cast attributes to specific data types
    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship: A case activity belongs to a case
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }

    // Accessor for user-friendly display (e.g., "First Hearing")
    public function getDisplayLabelAttribute()
    {
        $ordinal = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
        $word = ucfirst($ordinal->format($this->sequence_number)); // e.g. "first", "second"
        
        return "{$word} " . ucfirst($this->type); // e.g. "First Hearing"
    }


   
}
