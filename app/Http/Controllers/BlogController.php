<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Upload;
use App\Jobs\SendBlogNotification;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Blog\StoreBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $blogs = Blog::with('user')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->select('blogs.*');
            return DataTables::of($blogs)
                ->addIndexColumn()
                ->addColumn('author', function(Blog $blog) {
                    return $blog->user->name;
                })
                ->addColumn('action', function(Blog $blog) {
                    $view = '<a href="'.route('blogs.show', $blog->id).'" class="btn btn-outline-success btn-sm me-1"><i class="fa fa-eye"></i></a>';
                    $edit = '<a href="'.route('blogs.edit', $blog->id).'" class="btn btn-outline-primary btn-sm me-1"><i class="fa fa-pen"></i></a>';
                    $delete = '<form action="'.route('blogs.destroy', $blog->id).'" method="POST" style="display:inline" class="delete-form d-inline">'
                            . csrf_field()
                            . method_field('DELETE')
                            . '<button class="btn btn-outline-danger btn-sm delete-btn" data-module="blog" type="button"><i class="fa fa-trash"></i></button></form>';
                    return '<div class="d-flex gap-1">'.$view.$edit.$delete.'</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('blogs.index');
        // $blogs = Blog::latest()->get();
        // return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest  $request)
    {
        try {
            $data = $request->validated();

            // ORM (Eloquent)
            $blog = Blog::create([
                'title' => $request->title,  // $data['title'];
                'content' => $request->content,
                'user_id' => Auth::id()
            ]);
            // for image
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $path = $file->store('uploads/blog/feature_image', 'public');

                $blog->upload()->create([
                    'file_path' => $path,
                    'file_type' => 'image',
                ]);
            }
            
            //blog images
            if ($request->hasFile('blog_images')) {
                foreach ($request->file('blog_images') as $file) {
                    $path = $file->store('uploads/blog/images', 'public');

                    $blog->upload()->create([
                        'file_path' => $path,
                        'file_type' => 'blog_image',
                    ]);
                }
            }

            // PDF upload
            if ($request->hasFile('pdf_file')) {
                $pdf = $request->file('pdf_file');
                $path = $pdf->store('uploads/blog/pdf', 'public');

                $blog->pdf()->create([
                    'file_path' => $path,
                    'file_type' => 'pdf',
                ]);
            }

            $blog->details()->create([
                'ckeditor' => $request->content_ckeditor,
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
            SendBlogNotification::dispatch($blog);
            return response()->json([
                'status' => 'success',
                'message' => 'Blog created successfully'
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }

        // return redirect()->route('blogs.index')->with('success', 'Blog created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $blog->load('details','upload', 'pdf', 'blogImages');
        return view('blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        if ($blog->user_id !== Auth::id()) {
            abort(403);
        }

        $blog->load('details');

        return view('blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        if ($blog->user_id !== Auth::id()) {
            abort(403);
        }

        // Validation
        $data = $request->validated();

        $blog->update([
            'title'   => $request->title,
            'content' => $request->content
        ]);
        // for image
        if ($request->hasFile('file')) {

            // 🔥 1. Delete old file (if exists)
            if ($blog->upload) {
                Storage::disk('public')->delete($blog->upload->file_path);
                $blog->upload->delete(); // delete DB record
            }

            // 🔥 2. Store new file
            $file = $request->file('file');
            $path = $file->store('uploads/blog/feature_image', 'public');

            $blog->upload()->create([
                'file_path' => $path,
                'file_type' => 'image', // $file->getClientOriginalExtension(),
            ]);
        }
        // blog images
        if ($request->delete_images) {
            foreach ($request->delete_images as $id) {
                $img = Upload::find($id);
                Storage::disk('public')->delete($img->file_path);
                $img->delete();
            }
        }

        if ($request->hasFile('blog_images')) {
            foreach ($request->file('blog_images') as $file) {

                $path = $file->store('uploads/blog/images', 'public');

                $blog->upload()->create([
                    'file_path' => $path,
                    'file_type' => 'blog_image',
                ]);
            }
        }
        
        // for pdf
        if ($request->hasFile('pdf_file')) {
            if ($blog->pdf) {
                Storage::disk('public')->delete($blog->pdf->file_path);
                $blog->pdf->delete();
            }

            $file = $request->file('pdf_file');
            $path = $file->store('uploadsblog/pdf', 'public');

            $blog->pdf()->create([
                'file_path' => $path,
                'file_type' => 'pdf',
            ]);
        }

        $blog->details()->updateOrCreate(
            ['blog_id' => $blog->id],  
            [
                'ckeditor' => $request->content_ckeditor,
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

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->user_id !== Auth::id()) {
            abort(403);
        }

        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully');
    }
}
