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
                        <label class="form-label">Featured Image</label>
                        <input type="file" name="file" class="form-control" accept=".jpg,.jpeg,.png">
                        @error('file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Images</label>
                        <input type="file" name="post_images[]" multiple class="form-control" accept=".jpg,.jpeg,.png">
                        @error('post_images')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label>PDF:</label>
                        <input type="file" name="pdf_file" accept="application/pdf" class="form-control">
                        @error('pdf_file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <hr />
                    <div class="mb-3">
                        <h5>Additional Input Fields</h5>
                        <label>CkEditor</label>
                        <textarea name="ckeditor" class="form-control editor">{{ old('content') }}</textarea>
                        @error('ckeditor')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Number</label>
                        <input type="number" name="number" class="form-control" value="{{ old('number') }}">
                        @error('number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-control">
                            <option value="">Select category</option>
                            <option value="tech">Tech</option>
                            <option value="news">News</option>
                            <option value="sports">Sports</option>
                        </select>
                        @error('category')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label><br>
                        <label><input type="radio" name="status" value="active"> Active</label>
                        <label class="ms-3"><input type="radio" name="status" value="inactive"> Inactive</label>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tags</label><br>
                        <label><input type="checkbox" name="tags[]" value="php"> PHP</label>
                        <label class="ms-3"><input type="checkbox" name="tags[]" value="laravel"> Laravel</label>
                        <label class="ms-3"><input type="checkbox" name="tags[]" value="vue"> Vue</label>
                        @error('tags')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Publish Date</label>
                        <input type="date" name="publish_date" class="form-control" value="{{ old('publish_date') }}">
                        @error('publish_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Publish Time</label>
                        <input type="time" name="publish_time" class="form-control" value="{{ old('publish_time') }}">
                        @error('publish_time')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <input type="range" name="rating" id="rating" min="0" max="10" value="5" class="form-range">
                        <span id="ratingValue">5</span>
                        @error('rating')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pick Color</label>
                        <input type="color" name="color" class="form-control form-control-color">
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
                            Save Post
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection