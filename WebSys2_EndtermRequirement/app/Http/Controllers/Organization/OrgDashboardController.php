<?php

namespace App\Http\Controllers\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrgDashboardController extends Controller
{
    public function index()
    {
        return view('org.home')->with('layout', 'layouts.org');
    }
}
