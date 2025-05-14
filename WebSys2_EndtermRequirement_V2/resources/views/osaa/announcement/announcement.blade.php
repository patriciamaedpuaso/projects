@extends('layouts.osaa')

@section('content')
<div class="container mt-4" style="max-width: 800px;">

    {{-- Post New Announcement --}}
    <div class="card p-4 mb-4 shadow-sm border-0">
        <h4 class="card-title mb-3">Post New Announcement</h4>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success mb-3">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('osaa.announcement.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" name="title" id="title" class="form-control shadow-sm" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Body:</label>
                <textarea name="content" id="content" class="form-control shadow-sm" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">Attach File (optional):</label>
                <input type="file" name="file" id="file" class="form-control shadow-sm" accept=".pdf, .doc, .docx">
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Attach Image (optional):</label>
                <input type="file" name="image" id="image" accept="image/*" class="form-control shadow-sm">
            </div>

            <button type="submit" class="btn btn-primary w-100 shadow-sm">Post Announcement</button>
        </form>
    </div>

    {{-- All Announcements --}}
    <div class="mt-4">
        @foreach ($announcements as $announcement)
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body">
                    {{-- Author & Date --}}
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <strong>{{ $announcement->author }}</strong><br>
                            <small class="text-muted">{{ $announcement->created_at->format('F j, Y - g:i A') }}</small>
                        </div>
                        <form action="{{ route('osaa.announcement.destroy', $announcement->id) }}" method="POST" onsubmit="return confirm('Delete this announcement?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger shadow-sm">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>

                    {{-- Title --}}
                    <h5 class="mb-3">{{ $announcement->title }}</h5>

                    {{-- Body --}}
                    <p class="mb-3">{{ $announcement->body }}</p>

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

</div>
@endsection
