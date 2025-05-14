<?php

namespace App\Http\Controllers\Osaa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentOrganization;
use App\Models\AccreditationApplication;
use App\Models\Event;
use App\Models\Announcement;

class OsaaDashboardController extends Controller
{
    public function index()
    {
        // Fetch the statistics
        $organizationCount = StudentOrganization::count();
        $accreditationCount = AccreditationApplication::where('status', 'pending')->count();
        $upcomingEventsCount = Event::where('proposed_date', '>=', now())->count();
        $announcementCount = Announcement::count();

        // Fetch the recent 5 announcements
        $recentAnnouncements = Announcement::latest()->take(5)->get();

        // Return the view with the necessary data
        return view('osaa.home', compact(
            'organizationCount', 
            'accreditationCount', 
            'upcomingEventsCount', 
            'announcementCount', 
            'recentAnnouncements'
        ));
    }
}
