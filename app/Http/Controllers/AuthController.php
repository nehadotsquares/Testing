<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(StoreUserRequest $request)
    {
       $data = $request->validated(); 

        $user = User::create([
            'name' => $request->name,  // $data['name'] 
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        //profile image upload
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');

            $path = $file->store('profile_images', 'public');

            $user->upload()->create([
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
            ]);
        }

        return redirect('/login');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        // $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/posts');
        }

        return back()
        ->with('error', 'Invalid credentials')
        ->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
