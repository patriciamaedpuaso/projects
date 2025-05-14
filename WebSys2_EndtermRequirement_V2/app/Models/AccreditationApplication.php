<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccreditationApplication extends Model
{
    protected $fillable = [
        'student_organization_id',
        'type',
        'status',
        'submitted_at',
        'reviewed_at',
        'remarks',
    ];

    protected $casts = [
        'can_renew' => 'boolean',
    ];

    public function studentOrganization()
    {
        return $this->belongsTo(StudentOrganization::class);
    }

    public function documents()
    {
        return $this->hasMany(AccreditationDocument::class);
    }
}