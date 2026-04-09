<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {

            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/ckeditor', $filename);

            $url = asset('storage/ckeditor/' . $filename);

            return response()->json([
                'default' => $url
            ]);
        }
    }
}
