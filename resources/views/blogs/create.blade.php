@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                Create Blog
            </div>

            <div class="card-body">
                <form id="blogForm" action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
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
                        <div class="text-danger"></div>
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
                        <div class="text-danger"></div>
                        @error('content')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Featured Image</label>
                        <input type="file" name="file" class="form-control" accept=".jpg,.jpeg,.png">
                        <div class="text-danger"></div>
                        @error('file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Images</label>
                        <input type="file" name="blog_images[]" multiple class="form-control" accept=".jpg,.jpeg,.png">
                        <div class="text-danger"></div>
                        @error('blog_images')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label>PDF:</label>
                        <input type="file" name="pdf_file" accept="application/pdf" class="form-control">
                        <div class="text-danger"></div>
                        @error('pdf_file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <hr />
                    <div class="mb-3">
                        <h5>Additional Input Fields</h5>
                        <label>CkEditor</label>
                        <textarea name="content_ckeditor" class="form-control editor">{{ old('content_ckeditor') }}</textarea>
                        <div class="text-danger"></div>
                        @error('content_ckeditor')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Number</label>
                        <input type="number" name="number" class="form-control" value="{{ old('number') }}">
                        <div class="text-danger"></div>
                        @error('number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-control">
                            <option value="">Select category</option>
                            <option value="tech" {{ old('category') == 'tech' ? 'selected' : '' }}>Tech</option>
                            <option value="news" {{ old('category') == 'news' ? 'selected' : '' }}>News</option>
                            <option value="sports" {{ old('category') == 'sports' ? 'selected' : '' }}>Sports</option>
                        </select>
                        <div class="text-danger"></div>
                        @error('category')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label><br>
                        <label><input type="radio" name="status" value="active" {{ old('status') == 'active' ? 'checked' : '' }}> Active</label>
                        <label class="ms-3"><input type="radio" name="status" value="inactive" {{ old('status') == 'inactive' ? 'checked' : '' }}> Inactive</label>
                        <div class="text-danger"></div>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tags</label><br>
                        <label><input type="checkbox" name="tags[]" value="php" {{ in_array('php', old('tags', [])) ? 'checked' : '' }}> PHP</label>
                        <label class="ms-3"><input type="checkbox" name="tags[]" value="laravel" {{ in_array('laravel', old('tags', [])) ? 'checked' : '' }}> Laravel</label>
                        <label class="ms-3"><input type="checkbox" name="tags[]" value="vue" {{ in_array('vue', old('tags', [])) ? 'checked' : '' }}> Vue</label>
                        <div class="text-danger"></div>
                        @error('tags')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Publish Date</label>
                        <input type="date" name="publish_date" class="form-control" value="{{ old('publish_date') }}">
                        <div class="text-danger"></div>
                        @error('publish_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Publish Time</label>
                        <input type="time" name="publish_time" class="form-control" value="{{ old('publish_time') }}">
                        <div class="text-danger"></div>
                        @error('publish_time')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <input type="range" name="rating" id="rating" min="0" max="10" value="{{ old('rating', 5) }}" class="form-range">
                        <span id="ratingValue">{{ old('rating', 5) }}</span>
                        <div class="text-danger"></div>
                        @error('rating')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pick Color</label>
                        <input type="color" name="color" class="form-control form-control-color" value="{{ old('color', '#000000') }}">
                        <div class="text-danger"></div>
                        @error('color')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('blogs.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Save Blog
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    let editors = {};
    document.querySelectorAll('.editor').forEach((el) => {
        let name = el.getAttribute('name');

        ClassicEditor.create(el, {
            extraPlugins: [ MyCustomUploadAdapterPlugin ]
        })
        .then(editor => {
            editors[name] = editor;
        });
    });
    $(document).ready(function() {

        $('#blogForm').on('submit', function(e) {
            e.preventDefault();
            for (let key in editors) {
                $('textarea[name="' + key + '"]').val(editors[key].getData());
            }
            let formData = new FormData(this);
                                    
            $.ajax({
                url: "{{ route('blogs.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                beforeSend: function() {
                    $('.text-danger').text(""); // Clear validation errors
                },

                success: function(response) {
                    if (response.status === "success") {
                        toastr.success(response.message);

                        $('#blogForm')[0].reset();

                        for (let key in editors) {
                            editors[key].setData('');
                        }

                        // Clear all error messages
                        $('.text-danger').text('');
                    }
                },

                error: function(xhr) {
                    if (xhr.status === 422) {  
                        let errors = xhr.responseJSON.errors;

                        $.each(errors, function(key, value) {
                            let fieldName = key;

                            if (key === 'blog_images') fieldName = 'blog_images[]';
                            if (key === 'tags') fieldName = 'tags[]';

                            if (key === 'content_ckeditor') {
                                $('.editor').closest('.mb-3').find('.text-danger').text(value[0]);
                                return;
                            }

                            // Print error message
                            $(`[name="${fieldName}"]`)
                                .closest('.mb-3, .mb-4')
                                .find('.text-danger')
                                .text(value[0]);
                        });

                        toastr.error("Please fix validation errors.");
                    } 
                    else {
                        toastr.error(xhr.responseJSON.message);
                    }
                }
            });
        });

    });
</script>
@endsection