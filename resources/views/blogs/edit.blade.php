@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">

            <!-- Header -->
            <div class="card-header bg-primary text-white">
                Edit Blog
            </div>

            <!-- Body -->
            <div class="card-body">
                <form name="editBlogForm" action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input 
                            type="text" 
                            name="title" 
                            class="form-control"
                            value="{{ old('title', $blog->title) }}"
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
                        >{{ old('content', $blog->content) }}</textarea>
                        @error('content')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($blog->upload && in_array($blog->upload->file_type, ['image']))
                        <h6>Existing Image:</h6>
                        <a href="{{ asset('storage/' . $blog->upload->file_path) }}" target="_blank">
                            <img src="{{ asset('storage/' . $blog->upload->file_path) }}" width="150" class="mt-2">
                        </a>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Upload Feature Image</label>
                        <input type="file" name="file" class="form-control" accept=".jpg,.jpeg,.png">
                        @error('file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($blog->blogImages->count())
                        <div class="mt-3">
                            <h6>Existing Images:</h6>

                            @foreach($blog->blogImages as $img)
                                <div class="me-2 mb-2">
                                    <img src="{{ asset('storage/' . $img->file_path) }}" width="120" class="rounded border">

                                    <!-- Optional: Delete checkbox -->
                                    <label class="ms-2">
                                        <input type="checkbox" name="delete_images[]" value="{{ $img->id }}">
                                        Delete
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Upload Images</label>
                        <input type="file" name="blog_images[]" multiple class="form-control" accept=".jpg,.jpeg,.png">

                        @error('blog_images')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label>PDF:</label>
                        <input type="file" name="pdf_file" accept="application/pdf" class="form-control">
                        @if(isset($blog) && $blog->pdf)
                            <a href="{{ asset('storage/' . $blog->pdf->file_path) }}" target="_blank">View PDF</a>
                        @endif
                    </div>

                    <hr />

                    <div class="mb-3">
                        <h5>Additional Information</h5>
                        <label class="form-label">CkEditor</label>
                        <textarea name="ckeditor" class="form-control editor">
                            {{ old('ckeditor', optional($blog->details)->ckeditor) }}
                        </textarea>
                        @error('ckeditor')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Number</label>
                        <input type="number" name="number" class="form-control"
                            value="{{ old('number', optional($blog->details)->number) }}">
                        @error('number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-control">
                            <option value="">Select category</option>
                            <option value="tech" {{ old('category', optional($blog->details)->category) == 'tech' ? 'selected' : '' }}>Tech</option>
                            <option value="news" {{ old('category', optional($blog->details)->category) == 'news' ? 'selected' : '' }}>News</option>
                            <option value="sports" {{ old('category', optional($blog->details)->category) == 'sports' ? 'selected' : '' }}>Sports</option>
                        </select>
                        @error('category')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label><br>

                        <label>
                            <input type="radio" name="status" value="active"
                                {{ old('status', optional($blog->details)->status) == 'active' ? 'checked' : '' }}>
                            Active
                        </label>

                        <label class="ms-3">
                            <input type="radio" name="status" value="inactive"
                                {{ old('status', optional($blog->details)->status) == 'inactive' ? 'checked' : '' }}>
                            Inactive
                        </label>

                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    @php
                        $selectedTags = old('tags', optional($blog->details)->tags ?? []);
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
                            value="{{ old('publish_date', optional($blog->details)->publish_date) }}">
                        @error('publish_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Publish Time</label>
                        <input type="time" name="publish_time" class="form-control"
                            value="{{ old('publish_time', optional($blog->details)->publish_time) }}">
                        @error('publish_time')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror    
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <input type="range" name="rating" id="rating"
                            min="0" max="10"
                            value="{{ old('rating', optional($blog->details)->rating ?? 5) }}"
                            class="form-range">
                        <span id="ratingValue">{{ old('rating', optional($blog->details)->rating ?? 5) }}</span>
                        @error('rating')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pick Color</label>
                        <input type="color" name="color" class="form-control form-control-color"
                            value="{{ old('color', optional($blog->details)->color) }}">
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
                            Update Blog
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
    $(document).ready(function () {
        $('#editBlogForm').on('submit', function (e) {
            e.preventDefault();

            // Update CKEditor content into textarea
            for (let key in editors) {
                editors[key].updateSourceElement();
            }

            let formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,

                beforeSend: function () {
                    $('.text-danger').text("");
                },

                success: function (response) {
                    toastr.success(response.message);
                },

                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;

                        $.each(errors, function (key, value) {
                            let field = key;

                            if (key === 'blog_images') field = 'blog_images[]';
                            if (key === 'tags') field = 'tags[]';

                            if (key === 'ckeditor') {
                                $('[name="ckeditor"]').closest('.mb-3').find('.text-danger').text(value[0]);
                                return;
                            }

                            $(`[name="${field}"]`).closest('.mb-3, .mb-4')
                                .find('.text-danger').text(value[0]);
                        });

                        toastr.error("Fix validation errors.");
                    } else {
                        toastr.error("Something went wrong.");
                    }
                }
            });
        });

    });
</script>
@endsection