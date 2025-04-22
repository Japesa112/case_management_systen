<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseLawyer extends Model
{
    use HasFactory;

    // Define the table name if it doesn't follow Laravel's naming convention
    protected $table = 'case_lawyer';

    // Define the primary key, if it's not the default 'id'
    protected $primaryKey = 'assigned_id';

   

    // If you need to specify the columns you want to allow mass assignment
    protected $fillable = [
        'case_id',
        'lawyer_id'
        
    ];

    // Define relationships (if any), for example:
    // CaseLawyer belongs to a Case
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }

    // CaseLawyer belongs to a Lawyer
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id');
    }

    
}