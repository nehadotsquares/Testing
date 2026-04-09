<?php

namespace App\Http\Requests\Post;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $post = $this->route('post'); 
        return $post && $post->user_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:10|max:255',
            'content' => 'required|string|min:15',
            'file' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'post_images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'delete_images'   => 'array',
            'delete_images.*' => 'exists:uploads,id',
            'pdf_file'   => 'nullable|file|mimes:pdf|max:5120', 

            // additional fields
            'ckeditor'      => 'nullable|string',
            'number'        => 'nullable|integer',
            'category'      => 'nullable|string|in:tech,news,sports',
            'status'        => 'nullable|string|in:active,inactive',
            'tags'          => 'nullable|array',
            'publish_date'  => 'nullable|date',
            'publish_time'  => 'nullable',
            'rating'        => 'nullable|integer|min:0|max:10',
            'color'         => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required.',
            'title.min' => 'Title must be at least :min characters.',
            'title.max' => 'Title can be max :max characters.',
            'content.required' => 'Content is required.',
            'content.min' => 'Content must be at least :min characters.',
            'file.file' => 'The uploaded file must be a valid file.',
            'file.mimes' => 'Only JPG, JPEG, and PNG files are allowed.',
            'file.max' => 'File size must not exceed 2MB.',
            'post_images.required' => 'Please select at least one file.',
            'post_images.array' => 'Files must be an array.',
            'post_images.*.mimes' => 'Only JPG, JPEG, PNG, and PDF files are allowed.',
            'post_images.*.max' => 'Each file must not exceed 5MB.',
            'pdf_file.file' => 'The uploaded PDF must be a valid file.',
            'pdf_file.mimes' => 'Only PDF files are allowed.',

            // Additional Fields
            'ckeditor.string' => 'CkEditor content must be valid text.',

            'number.integer' => 'Number field must be a valid integer.',

            'category.string' => 'Category must be a valid string.',
            'category.in' => 'Please select a valid category (tech, news, sports).',

            'status.string' => 'Status must be a valid string.',
            'status.in' => 'Status must be either Active or Inactive.',

            'tags.array' => 'Tags must be an array of values.',

            'publish_date.date' => 'Publish date must be a valid date.',

            'publish_time.date_format' => 'Publish time must be a valid time.',

            'rating.integer' => 'Rating must be a number.',
            'rating.min' => 'Rating must be at least :min.',
            'rating.max' => 'Rating cannot be more than :max.',

            'color.string' => 'Color value must be a valid hex color string.',
        ];
    }
}
