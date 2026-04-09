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
                    {!! $post->content !!}
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

                <hr>

                <h5>Additional Information</h5>

                @if($post->details)
                    <p><strong>CKEditor:</strong></p>
                    <div class="border p-2">{!! $post->details->ckeditor !!}</div>

                    <p class="mt-2">
                        <strong>Number:</strong> {{ $post->details->number }}
                    </p>

                    <p>
                        <strong>Category:</strong> {{ ucfirst($post->details->category) }}
                    </p>

                    <p>
                        <strong>Status:</strong> 
                        <span class="badge bg-{{ $post->details->status == 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($post->details->status) }}
                        </span>
                    </p>

                    <p>
                        <strong>Tags:</strong> 
                        @foreach($post->details->tags ?? [] as $tag)
                            <span class="badge bg-primary">{{ $tag }}</span>
                        @endforeach
                    </p>

                    <p>
                        <strong>Publish Date:</strong> {{ $post->details->publish_date }}
                    </p>

                    <p>
                        <strong>Publish Time:</strong> {{ $post->details->publish_time }}
                    </p>

                    <p>
                        <strong>Rating:</strong> {{ $post->details->rating }}/10
                    </p>

                    <p>
                        <strong>Color:</strong> 
                        <span style="padding: 4px 20px; border-radius: 5px; display:inline-block; background: {{ $post->details->color }}; "></span>
                        {{ $post->details->color }}
                    </p>

                @else
                    <p class="text-muted">No additional details available.</p>
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