<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Use Authenticatable instead of Model
use Illuminate\Notifications\Notifiable;

class Osaa extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role']; // Add 'role' to fillable

    protected $hidden = ['password']; // Make sure the password is hidden when serialized

    // Add any other relationships or methods if needed
}
