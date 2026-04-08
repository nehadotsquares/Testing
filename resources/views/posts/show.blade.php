@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">

            <!-- Header -->
            <div class="card-header bg-primary text-white">
                Post Details
            </div>

            <!-- Body -->
            <div class="card-body">
                <h6 class="card-title">{{ $post->title }}</h6>

                <p class="text-muted mb-2">
                    Author: <strong>{{ $post->user->name }}</strong>
                </p>

                <hr>

                <p class="card-text">
                    {{ $post->content }}
                </p>

                @if($post->upload || $post->pdf)
                    <div class="mt-3">
                        <h6>Attachment:</h6>

                        @if($post->upload)                      
                            <a href="{{ asset('storage/' . $post->upload->file_path) }}" target="_blank" class="btn btn-outline-info btn-sm mb-1">
                                View File
                            </a>
                        @endif

                        @if($post->pdf)
                            <a href="{{ asset('storage/' . $post->pdf->file_path) }}" target="_blank" class="btn btn-outline-info btn-sm mb-1">
                                View PDF
                            </a>
                        @endif
                    </div>
                @endif
                
            </div>

            <!-- Footer -->
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                    Back
                </a>

                <div>
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="delete-form d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm delete-btn">
                            Delete
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection