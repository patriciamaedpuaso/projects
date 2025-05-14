<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_organization_id',
        'name',
        'course',
        'year_level',
        'position',
        'is_officer',
    ];

    public function studentOrganization() {
        return $this->belongsTo(StudentOrganization::class);
    }
}
