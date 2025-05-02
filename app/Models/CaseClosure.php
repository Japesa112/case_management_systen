<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CaseClosure extends Model
{
    use HasFactory;

    protected $table = 'caseclosures';
    protected $primaryKey = 'closure_id';

    protected $fillable = [
        'case_id', 'closure_date', 'final_outcome', 'follow_up_actions',
        'lawyer_payment_confirmed', 
    ];

    public function attachments()
    {
        return $this->hasMany(CaseClosureAttachment::class, 'caseclosure_id');
    }

    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_id');
    }
}
