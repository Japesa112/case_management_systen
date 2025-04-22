<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AGAdvice extends Model
{
    //

     use HasFactory;

    protected $table = 'evaluation_ag_advice'; // Set the table name (if not following Laravel naming conventions)

    protected $primaryKey = 'ag_advice_id'; // Define the primary key

    public $timestamps = false; // Disable created_at & updated_at if not needed

    protected $fillable = [
        'evaluation_id',
        'advice_date',
        'ag_advice',
        'case_id',
    ];

    // Relationship with the Case model
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }

    // Relationship with the Evaluation model
    public function evaluation()
    {
        return $this->belongsTo(PanelEvaluation::class, 'evaluation_id');
    }

}
