@component('mail::message')
# New Post Created

A new post has been created:

**Title:** {{ $post->title }}

**Content:**  
{{ $post->content }}

@component('mail::button', ['url' => route('posts.show', $post->id)])
View Post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent