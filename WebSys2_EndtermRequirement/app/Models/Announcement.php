<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'target_audience',
        'created_by',
    ];

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
