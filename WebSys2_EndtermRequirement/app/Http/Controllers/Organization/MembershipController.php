<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        return view('org.membership.index'); // Create this view to manage membership
    }
}
