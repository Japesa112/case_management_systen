<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;
class CaseModel extends Model
{
    use HasFactory;
   
    protected $table = 'cases'; 
    protected $primaryKey = 'case_id'; 
    protected $fillable = [
        'track_number',
        'case_number',
        'case_name',
        'date_received',
        'time_received',
        'case_description',
        'case_status',
        'case_category',
        'initial_status',
        'created_by',
     
    ];
    

    // Relationship to User Model (Assuming you have a User model)
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function negotiations()
{
    return $this->hasMany(Negotiation::class, 'case_id', 'case_id');
}
public function appeals()
{
    return $this->hasMany(Appeal::class, 'case_id', 'case_id');
}
public function adjourns()
{
    return $this->hasMany(Adjourn::class, 'case_id', 'case_id');
}
public function witnesses()
{
    return $this->hasMany(Witness::class, 'case_id', 'case_id');
}
public function lawyers()
{
    return $this->hasMany(Lawyer::class, 'case_id', 'case_id');
}

public function evaluations()
{
    return $this->hasMany(PanelEvaluation::class, 'case_id', 'case_id');
}

public function caseLawyers()
{
    return $this->hasMany(CaseLawyer::class, 'case_id');
}

public function lawyers1()
{
    return $this->belongsToMany(Lawyer::class, 'case_lawyer', 'case_id', 'lawyer_id');
}

public function forwardings()
{
    return $this->hasMany(Forwarding::class, 'case_id', 'case_id');
}



}
