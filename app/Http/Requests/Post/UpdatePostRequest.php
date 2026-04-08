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
            'pdf_file'   => 'nullable|file|mimes:pdf|max:5120', 
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
            'pdf_file.file' => 'The uploaded PDF must be a valid file.',
            'pdf_file.mimes' => 'Only PDF files are allowed.',
        ];
    }
}
