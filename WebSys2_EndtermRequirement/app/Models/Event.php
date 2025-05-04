<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_organization_id',
        'title',
        'description',
        'proposed_date',
        'status',
        'feedback',
    ];

    public function organization()
    {
        return $this->belongsTo(StudentOrganization::class, 'student_organization_id');
    }

    public function documents()
    {
        return $this->hasMany(EventDocument::class);
    }
}
