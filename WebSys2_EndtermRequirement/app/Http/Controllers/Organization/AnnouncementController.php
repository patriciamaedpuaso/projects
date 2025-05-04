<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        return view('org.announcements.index'); // Create this view to manage announcements
    }
}
