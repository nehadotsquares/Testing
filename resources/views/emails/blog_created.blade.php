@component('mail::message')
# New Blog Created

A new blog has been created:

**Title:** {{ $blog->title }}

**Content:**  
{{ $blog->content }}

@component('mail::button', ['url' => route('blogs.show', $blog->id)])
View Blog
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent