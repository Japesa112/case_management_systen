<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CaseModel;
class CaseDocument extends Model
{
    use HasFactory;
    protected $table = 'case_documents'; // Ensure the correct table name
    protected $primaryKey = 'document_id'; // Set the correct primary key
    protected $fillable = [
        'document_name',
        'case_id',
    ];

    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }
}
