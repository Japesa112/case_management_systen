<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lawyer extends Model
{
    use HasFactory;

    protected $primaryKey = 'lawyer_id'; 
    protected $table = 'lawyers'; 
    protected $fillable = [
        'user_id', 'license_number', 'area_of_expertise', 'firm_name', 'years_experience', 'working_hours'
    ];
    

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function trialPreparations(): BelongsToMany
{
    return $this->belongsToMany(TrialPreparation::class, 'trial_preparation_lawyer', 'lawyer_id', 'preparation_id')
                ->withTimestamps();
}

public function cases()
{
    return $this->belongsToMany(CaseModel::class, 'case_lawyer', 'lawyer_id', 'case_id');
}




}
