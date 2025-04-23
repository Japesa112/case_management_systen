<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Lawyer;
class PanelEvaluation extends Model
{
    use HasFactory;

    protected $table = 'evaluations'; // Ensure this matches your table name
    protected $primaryKey = 'evaluation_id'; // Primary key

    protected $fillable = [
        'case_id',
        'lawyer_id',
        'evaluation_date',
        'evaluation_time',
        'comments',
        'quote',
        'pager',
        'outcome',
        'worked_before', // Added this field
    ];

    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id'); // Adjust if needed
    }

    public function user()
{
    return $this->belongsTo(User::class, 'lawyer_id'); // Ensure this matches the column in evaluations
}


    
}