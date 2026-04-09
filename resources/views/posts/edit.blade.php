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
                    
                    <div class="mb-4">
                        <label>PDF:</label>
                        <input type="file" name="pdf_file" accept="application/pdf" class="form-control">
                        @if(isset($post) && $post->pdf)
                            <a href="{{ asset('storage/' . $post->pdf->file_path) }}" target="_blank">View PDF</a>
                        @endif
                    </div>

                    <hr />

                    <div class="mb-3">
                        <h5>Additional Information</h5>
                        <label class="form-label">CkEditor</label>
                        <textarea name="ckeditor" class="form-control editor">
                            {{ old('ckeditor', optional($post->details)->ckeditor) }}
                        </textarea>
                        @error('ckeditor')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Number</label>
                        <input type="number" name="number" class="form-control"
                            value="{{ old('number', optional($post->details)->number) }}">
                        @error('number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-control">
                            <option value="">Select category</option>
                            <option value="tech" {{ old('category', optional($post->details)->category) == 'tech' ? 'selected' : '' }}>Tech</option>
                            <option value="news" {{ old('category', optional($post->details)->category) == 'news' ? 'selected' : '' }}>News</option>
                            <option value="sports" {{ old('category', optional($post->details)->category) == 'sports' ? 'selected' : '' }}>Sports</option>
                        </select>
                        @error('category')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label><br>

                        <label>
                            <input type="radio" name="status" value="active"
                                {{ old('status', optional($post->details)->status) == 'active' ? 'checked' : '' }}>
                            Active
                        </label>

                        <label class="ms-3">
                            <input type="radio" name="status" value="inactive"
                                {{ old('status', optional($post->details)->status) == 'inactive' ? 'checked' : '' }}>
                            Inactive
                        </label>

                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    @php
                        $selectedTags = old('tags', optional($post->details)->tags ?? []);
                    @endphp

                    <div class="mb-3">
                        <label class="form-label">Tags</label><br>

                        <label><input type="checkbox" name="tags[]" value="php"     {{ in_array('php', $selectedTags) ? 'checked' : '' }}> PHP</label>
                        <label class="ms-3"><input type="checkbox" name="tags[]" value="laravel" {{ in_array('laravel', $selectedTags) ? 'checked' : '' }}> Laravel</label>
                        <label class="ms-3"><input type="checkbox" name="tags[]" value="vue"     {{ in_array('vue', $selectedTags) ? 'checked' : '' }}> Vue</label>
                        @error('tags')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Publish Date</label>
                        <input type="date" name="publish_date" class="form-control"
                            value="{{ old('publish_date', optional($post->details)->publish_date) }}">
                        @error('publish_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Publish Time</label>
                        <input type="time" name="publish_time" class="form-control"
                            value="{{ old('publish_time', optional($post->details)->publish_time) }}">
                        @error('publish_time')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror    
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <input type="range" name="rating" id="rating"
                            min="0" max="10"
                            value="{{ old('rating', optional($post->details)->rating ?? 5) }}"
                            class="form-range">
                        <span id="ratingValue">{{ old('rating', optional($post->details)->rating ?? 5) }}</span>
                        @error('rating')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pick Color</label>
                        <input type="color" name="color" class="form-control form-control-color"
                            value="{{ old('color', optional($post->details)->color) }}">
                        @error('color')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
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