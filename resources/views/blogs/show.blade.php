@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">

            <!-- Header -->
            <div class="card-header bg-primary text-white">
                Blog Details
            </div>

            <!-- Body -->
            <div class="card-body">
                <h6 class="card-title">{{ $blog->title }}</h6>

                <p class="text-muted mb-2">
                    Author: <strong>{{ $blog->user->name }}</strong>
                </p>

                <hr>

                <p class="card-text">
                    {!! $blog->content !!}
                </p>

                @if($blog->upload || $blog->pdf)
                    <div class="mt-3">
                        <h6>Attachment:</h6>

                        @if($blog->upload)                      
                            <a href="{{ asset('storage/' . $blog->upload->file_path) }}" target="_blank" class="btn btn-outline-info btn-sm mb-1">
                                View Feature Image
                            </a>
                        @endif

                        @if($blog->pdf)
                            <a href="{{ asset('storage/' . $blog->pdf->file_path) }}" target="_blank" class="btn btn-outline-info btn-sm mb-1">
                                View PDF
                            </a>
                        @endif
                    </div>
                @endif

                @if($blog->blogImages->count() > 0)
                    <div class="mt-3">
                        <h6>Blog Images:</h6>

                        @foreach($blog->blogImages as $image)
                            <a href="{{ asset('storage/' . $image->file_path) }}" target="_blank" class="mb-1">
                            <img src="{{ asset('storage/' . $image->file_path) }}" 
                                alt="Blog Image" 
                                style="width:100px; margin:5px;">
                            </a>
                        @endforeach
                    </div>
                @endif

                <hr>

                <h5>Additional Information</h5>

                @if($blog->details)
                    <p><strong>CKEditor:</strong></p>
                    <div class="border p-2">{!! $blog->details->ckeditor !!}</div>

                    <p class="mt-2">
                        <strong>Number:</strong> {{ $blog->details->number }}
                    </p>

                    <p>
                        <strong>Category:</strong> {{ ucfirst($blog->details->category) }}
                    </p>

                    <p>
                        <strong>Status:</strong> 
                        <span class="badge bg-{{ $blog->details->status == 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($blog->details->status) }}
                        </span>
                    </p>

                    <p>
                        <strong>Tags:</strong> 
                        @foreach($blog->details->tags ?? [] as $tag)
                            <span class="badge bg-primary">{{ $tag }}</span>
                        @endforeach
                    </p>

                    <p>
                        <strong>Publish Date:</strong> {{ $blog->details->publish_date }}
                    </p>

                    <p>
                        <strong>Publish Time:</strong> {{ $blog->details->publish_time }}
                    </p>

                    <p>
                        <strong>Rating:</strong> {{ $blog->details->rating }}/10
                    </p>

                    <p>
                        <strong>Color:</strong> 
                        <span style="padding: 4px 20px; border-radius: 5px; display:inline-block; background: {{ $blog->details->color }}; "></span>
                        {{ $blog->details->color }}
                    </p>

                @else
                    <p class="text-muted">No additional details available.</p>
                @endif
                
            </div>

            <!-- Footer -->
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('blogs.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i>
                </a>

                <div>
                    <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-pen"></i>
                    </a>

                    <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="delete-form d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm delete-btn">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection