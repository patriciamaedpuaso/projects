<?php

namespace App\Http\Controllers\Osaa;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OsaaAnnouncement;
use Illuminate\Support\Facades\Storage;

class OsaaAnnouncementController extends Controller
{
    public function index()
    {
        $announcements = OsaaAnnouncement::latest()->get();
        return view('osaa.announcement.announcement', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'file' => 'nullable|file|max:10240', // 10MB
            'image' => 'nullable|image|max:5120', // 5MB
        ]);
    
        // Get the ID of the authenticated user (from osaas table)
        $userId = auth('osaa')->user()->id ?? null;
    
        // Check if a user is authenticated
        if (!$userId) {
            return redirect()->back()->with('error', 'You must be logged in to post an announcement.');
        }
    
        // Handle file upload if exists
        $filePath = $request->file('file') ? $request->file('file')->store('announcements/files', 'public') : null;
        $imagePath = $request->file('image') ? $request->file('image')->store('announcements/images', 'public') : null;
    
        // Create the announcement
        OsaaAnnouncement::create([
            'title' => $request->title,
            'author' => auth('osaa')->user()->name ?? 'Admin', // Get author name from logged-in user
            'body' => $request->content,
            'created_by' => $userId, // Set the created_by field to the logged-in user's ID
            'file' => $filePath,
            'image' => $imagePath,
        ]);
    
        return redirect()->back()->with('success', 'Announcement posted successfully.');
    }
    


    public function destroy($id)
    {
        $announcement = OsaaAnnouncement::findOrFail($id);

        if ($announcement->file_path) Storage::disk('public')->delete($announcement->file_path);
        if ($announcement->image_path) Storage::disk('public')->delete($announcement->image_path);

        $announcement->delete();

        return redirect()->back()->with('success', 'Announcement deleted.');
    }
}
