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
        'remarks',
        'reviewed_at', // Added to fillable fields
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime', // Ensure reviewed_at is casted as a datetime
    ];

    /**
     * Relationship with StudentOrganization
     */
    public function studentOrganization() 
    {
        return $this->belongsTo(StudentOrganization::class);
    }

    /**
     * Scope to filter reports by status
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeReviewed($query)
    {
        return $query->where('status', 'reviewed');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
