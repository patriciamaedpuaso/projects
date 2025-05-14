<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class OSAA extends Authenticatable
{
    use Notifiable;

    protected $table = 'osaas';

    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'role', 
        'profile_image'];


    protected $hidden = [
        'password',
    ];
}
