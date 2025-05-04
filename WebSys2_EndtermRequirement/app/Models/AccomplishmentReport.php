<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccomplishmentReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_organization_id',
        'title',
        'file_path',
        'status',
        'submitted_at',
    ];

    public function studentOrganization() {
        return $this->belongsTo(StudentOrganization::class);
    }
}
