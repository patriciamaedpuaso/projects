<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccreditationDocument extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'accreditation_application_id',
        'document_type',
        'file_path',
        'uploaded_at',
    ];

    public function application()
    {
        return $this->belongsTo(AccreditationApplication::class, 'accreditation_application_id');
    }
}
