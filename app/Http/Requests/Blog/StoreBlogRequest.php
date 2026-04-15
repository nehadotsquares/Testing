<?php

namespace App\Http\Requests\Blog;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            'file' => 'required|mimes:jpg,jpeg,png|max:2048',
            'blog_images' => 'required|array',
            'blog_images.*' => 'mimes:jpg,jpeg,png,pdf|max:5120',
            'pdf_file'   => 'required|file|mimes:pdf|max:5120',

            // additional fields
            'content_ckeditor' => 'required|string',
            'number'        => 'required|integer',
            'category'      => 'required|string|in:tech,news,sports',
            'status'        => 'required|string|in:active,inactive',
            'tags'          => 'required|array',
            'publish_date'  => 'required|date',
            'publish_time'  => 'required',
            'rating'        => 'required|integer|min:0|max:10',
            'color'         => 'required|string',
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

            'file.required' => 'Image is required.',
            'file.file' => 'The uploaded file must be a valid file.',
            'file.mimes' => 'Only JPG, JPEG, and PNG files are allowed.',
            'file.max' => 'File size must not exceed 2MB.',

            'blog_images.required' => 'Please select at least one file.',
            'blog_images.array' => 'Files must be an array.',
            'blog_images.*.mimes' => 'Only JPG, JPEG, PNG, and PDF files are allowed.',
            'blog_images.*.max' => 'Each file must not exceed 5MB.',

            'pdf_file.required' => 'PDF file is required.',
            'pdf_file.file' => 'The uploaded PDF must be a valid file.',
            'pdf_file.mimes' => 'Only PDF files are allowed.',

            // Additional Fields
            'content_ckeditor.required' => 'CkEditor content is required',
            'content_ckeditor.string' => 'CkEditor content must be valid text.',

            'number.required' => 'Number field is required',
            'number.integer' => 'Number field must be a valid integer.',

            'category.required' => 'Category is required',
            'category.string' => 'Category must be a valid string.',
            'category.in' => 'Please select a valid category (tech, news, sports).',

            'status.required' => 'Status is required',
            'status.string' => 'Status must be a valid string.',
            'status.in' => 'Status must be either Active or Inactive.',

            'tags.required' => 'Tags is required',
            'tags.array' => 'Tags must be an array of values.',
            
            'publish_date.required' => 'Publish date is required',
            'publish_date.date' => 'Publish date must be a valid date.',
            
            'publish_time.required' => 'Publish time is required',
            'publish_time.date_format' => 'Publish time must be a valid time.',

            'rating.required' => 'Rating is required',
            'rating.integer' => 'Rating must be a number.',
            'rating.min' => 'Rating must be at least :min.',
            'rating.max' => 'Rating cannot be more than :max.',

            'color.required' => 'Color value is required',
            'color.string' => 'Color value must be a valid hex color string.',
        ];
    }
}
