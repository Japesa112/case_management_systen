<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AppealAttachment extends Model {
    use HasFactory;

    protected $table = 'appeal_attachments';
    protected $primaryKey = 'attachment_id';
    protected $fillable = ['appeal_id', 'file_name', 'file_path', 'file_type', 'upload_date'];

    public function appeal() {
        return $this->belongsTo(Appeal::class, 'appeal_id');
    }
}