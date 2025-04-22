<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Witness extends Model
{
    use HasFactory;

    protected $table = 'witnesses';
    protected $primaryKey = 'witness_id';
    public $timestamps = true; // Ensures created_at and updated_at are managed

    protected $fillable = [
        'case_id',
        'witness_name',
        'phone',
        'email',
        'availability',
        'witness_statement',
    ];

    // Relationship: One Witness has many Attachments
    public function attachments()
    {
        return $this->hasMany(WitnessAttachment::class, 'witness_id', 'witness_id');
    }
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }
}
