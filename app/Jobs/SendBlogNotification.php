<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Blog;
use Illuminate\Support\Facades\Mail;
use App\Mail\BlogCreatedMail;

class SendBlogNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $blog;
    /**
     * Create a new job instance.
     */
    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->blog->user->email)->send(new BlogCreatedMail($this->blog));
        \Log::info('Blog created: ' . $this->blog->title);
    }
}
