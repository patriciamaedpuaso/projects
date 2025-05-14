<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\OsaaAnnouncement;

class AnnouncementController extends Controller
{
    public function index()
    {
        // Fetch all announcements from the OsaaAnnouncement model
        $announcements = OsaaAnnouncement::all();

        // Pass the announcements to the view
        return view('org.announcements.index', compact('announcements'));
    }
}
