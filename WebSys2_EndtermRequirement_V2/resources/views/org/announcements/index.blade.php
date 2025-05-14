@extends('layouts.org')

@section('content')
{{-- All Announcements --}}
<div class="container mt-4" style="max-width: 800px;"> <!-- Reduced container size -->
    @foreach ($announcements->sortByDesc('created_at') as $announcement) <!-- Display latest first -->
        <div class="card shadow-sm mb-4 border-0 rounded">
            <div class="card-body">
                {{-- Author & Date --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <div>
                            <strong>Admin:</strong> {{ $announcement->author }} <!-- Display the admin's name -->
                            <div class="text-muted small">{{ $announcement->created_at->format('F j, Y - g:i A') }}</div>
                        </div>
                    </div>
                </div>

                {{-- Title --}}
                <h5 class="mb-3 text-primary">{{ $announcement->title }}</h5>

                {{-- Body --}}
                <p class="mb-3 text-dark">{{ $announcement->body }}</p>

                {{-- Display Image if Available --}}
                @if ($announcement->image)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $announcement->image) }}" alt="Announcement Image"
                             class="img-fluid rounded shadow-sm" style="max-height: 300px; object-fit: cover;">
                    </div>
                @endif

                {{-- File Download with Name --}}
                @if ($announcement->file)
                    <div class="mb-3">
                        <strong>📎 File:</strong>
                        <a href="{{ asset('storage/' . $announcement->file) }}" target="_blank" class="d-block text-primary mt-2">
                            <i class="bi bi-download"></i> {{ basename($announcement->file) }}
                        </a>
                    </div>
                @endif

            </div>
        </div>
    @endforeach
</div>
@endsection
