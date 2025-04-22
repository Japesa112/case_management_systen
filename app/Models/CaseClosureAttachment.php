<?php   

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseClosureAttachment extends Model
{
    use HasFactory;

    protected $table = 'caseclosure_attachments';
    protected $primaryKey = 'attachment_id';

    protected $fillable = ['caseclosure_id', 'file_name', 'file_path', 'file_type', 'upload_date'];

    public function caseClosure()
    {
        return $this->belongsTo(CaseClosure::class, 'caseclosure_id');
    }
}
