<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CaseModel;
class Complainant extends Model
{
    use HasFactory;
    protected $primaryKey = 'Complainant_id'; // Change to match your actual primary key

    protected $fillable = ['complainant_name', 'phone', 'email', 'address', 'case_id'];
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }
}
