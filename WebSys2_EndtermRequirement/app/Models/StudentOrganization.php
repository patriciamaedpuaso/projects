<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentOrganization extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'organization_name',
        'email',
        'password',
        'adviser_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function accreditationApplications(): HasMany
    {
        return $this->hasMany(AccreditationApplication::class);
    }
}
