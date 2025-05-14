<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReaccreditationController extends Controller
{
    public function index()
    {
        return view('org.reaccreditation.index'); // Create this view to manage reaccreditation
    }
}
