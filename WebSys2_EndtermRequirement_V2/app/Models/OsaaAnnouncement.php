<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OsaaAnnouncement extends Model
{
    protected $table = 'osaa_announcements'; // Set correct table name

    protected $fillable = [
        'title',
        'body',
        'file',
        'image',
        'created_by',
    ];

    // Optional: Relationship to OSAAS user
    public function creator()
    {
        return $this->belongsTo(Osaa::class, 'created_by');
    }
}
