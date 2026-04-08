@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                Create Post
            </div>

            <div class="card-body">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input 
                            type="text" 
                            name="title" 
                            class="form-control" 
                            placeholder="Enter title"
                            value="{{ old('title') }}"
                        >
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea 
                            name="content" 
                            class="form-control" 
                            rows="5"
                            placeholder="Enter content"
                        >{{ old('content') }}</textarea>
                        @error('content')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload File</label>
                        <input type="file" name="file" class="form-control" accept=".jpg,.jpeg,.png">
                        @error('file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>PDF:</label>
                        <input type="file" name="pdf_file" accept="application/pdf" class="form-control">
                        @error('pdf_file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                            Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Save Post
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection