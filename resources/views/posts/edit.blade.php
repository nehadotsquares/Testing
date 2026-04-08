@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">

            <!-- Header -->
            <div class="card-header bg-primary text-white">
                Edit Post
            </div>

            <!-- Body -->
            <div class="card-body">
                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input 
                            type="text" 
                            name="title" 
                            class="form-control"
                            value="{{ old('title', $post->title) }}"
                            placeholder="Enter title"
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
                        >{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($post->upload && in_array($post->upload->file_type, ['image']))
                        <a href="{{ asset('storage/' . $post->upload->file_path) }}" target="_blank">
                            <img src="{{ asset('storage/' . $post->upload->file_path) }}" width="150" class="mt-2">
                        </a>
                    @endif

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
                        @if(isset($post) && $post->pdf)
                            <a href="{{ asset('storage/' . $post->pdf->file_path) }}" target="_blank">View PDF</a>
                        @endif
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                            Back
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Update Post
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
@endsection