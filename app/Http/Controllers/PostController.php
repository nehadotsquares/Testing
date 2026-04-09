<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Jobs\SendPostNotification;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $posts = Post::with('user')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->select('posts.*');
            return DataTables::of($posts)
                ->addIndexColumn()
                ->addColumn('author', function(Post $post) {
                    return $post->user->name;
                })
                ->addColumn('action', function(Post $post) {
                    $view = '<a href="'.route('posts.show', $post->id).'" class="btn btn-info btn-sm me-1">View</a>';
                    $edit = '<a href="'.route('posts.edit', $post->id).'" class="btn btn-primary btn-sm me-1">Edit</a>';
                    $delete = '<form action="'.route('posts.destroy', $post->id).'" method="POST" style="display:inline" class="delete-form d-inline">'
                            . csrf_field()
                            . method_field('DELETE')
                            . '<button class="btn btn-danger btn-sm delete-btn" type="button">Delete</button></form>';
                    return '<div class="d-flex gap-1">'.$view.$edit.$delete.'</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('posts.index');
        // $posts = Post::latest()->get();
        // return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest  $request)
    {
        $data = $request->validated();

        // ORM (Eloquent)
        $post = Post::create([
            'title' => $request->title,  // $data['title'];
            'content' => $request->content,
            'user_id' => Auth::id()
        ]);
        // for image
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $path = $file->store('uploads', 'public');

            $post->upload()->create([
                'file_path' => $path,
                'file_type' => 'image',
            ]);
        }

        // PDF upload
        if ($request->hasFile('pdf_file')) {
            $pdf = $request->file('pdf_file');
            $path = $pdf->store('uploads', 'public');

            $post->pdf()->create([
                'file_path' => $path,
                'file_type' => 'pdf',
            ]);
        }

        $post->details()->create([
            'ckeditor' => $request->ckeditor,
            'number' => $request->number,
            'category' => $request->category,
            'status' => $request->status,
            'tags' => $request->tags,   // array
            'publish_date' => $request->publish_date,
            'publish_time' => $request->publish_time,
            'rating' => $request->rating,
            'color' => $request->color,
        ]);


        // Dispatch Job (Queue)
        SendPostNotification::dispatch($post);

        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load('details','upload', 'pdf');
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->load('details');

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        // Validation
        $data = $request->validated();

        $post->update([
            'title'   => $request->title,
            'content' => $request->content
        ]);
        // for image
        if ($request->hasFile('file')) {

            // 🔥 1. Delete old file (if exists)
            if ($post->upload) {
                Storage::disk('public')->delete($post->upload->file_path);
                $post->upload->delete(); // delete DB record
            }

            // 🔥 2. Store new file
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');

            $post->upload()->create([
                'file_path' => $path,
                'file_type' => 'image', // $file->getClientOriginalExtension(),
            ]);
        }
        // for pdf
        if ($request->hasFile('pdf_file')) {
            if ($post->pdf) {
                Storage::disk('public')->delete($post->pdf->file_path);
                $post->pdf->delete();
            }

            $file = $request->file('pdf_file');
            $path = $file->store('uploads', 'public');

            $post->pdf()->create([
                'file_path' => $path,
                'file_type' => 'pdf',
            ]);
        }

        $post->details()->updateOrCreate(
            ['post_id' => $post->id],  
            [
                'ckeditor' => $request->ckeditor,
                'number' => $request->number,
                'category' => $request->category,
                'status' => $request->status,
                'tags' => $request->tags,
                'publish_date' => $request->publish_date,
                'publish_time' => $request->publish_time,
                'rating' => $request->rating,
                'color' => $request->color,
            ]
        );

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }
}
