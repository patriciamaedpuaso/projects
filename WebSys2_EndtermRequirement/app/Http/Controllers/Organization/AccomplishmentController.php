<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccomplishmentController extends Controller
{
    public function index()
    {
        return view('org.accomplishments.index'); // Create this view for managing accomplishments
    }
}
