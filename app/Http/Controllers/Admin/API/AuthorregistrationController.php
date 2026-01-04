<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetLinKmail;

class AuthorregistrationController extends Controller
{
    public function loginform()
    {
        return view('adminpaneal.authauthor.login');
    }

    public function register(Request $request)
    {
        $messages = [
            'email.unique' => 'This email is already registered. Please login instead.',
        ];

        $validateUser = Validator::make(
            $request->all(),
            [
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:authors,email',
                'password' => 'required|min:6|confirmed',
                'image'    => 'image|mimes:jpg,jpeg,png|max:2048'
            ],
            $messages
        );


        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()->all(),

            ], 401);
        }

        $img = $request->image;
        $text = $img->getClientOriginalExtension();
        $imagename = time() . "." . $text;
        $img->move(public_path() . '/uploads', $imagename);

        $author = Author::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'image'  => $imagename
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Your request has been submitted for approval. Once it is approved, you will receive a confirmation email.',
            'author' => $author,

        ], 200);
    }

    public function login(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation errors',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Find author
        $author = Author::where('email', $request->email)->first();

        if (!$author) {
            return response()->json([
                'status' => false,
                'message' => 'Author not registered!'
            ], 404);
        }

        // Attempt login with 'author' guard
        if (!Auth::guard('author')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials!'
            ], 401);
        }

        // Check if author is approved
        if ($author->status == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Your account is not approved!'
            ], 403);
        }

        if ($author->status == 3) {
            return response()->json([
                'status' => false,
                'message' => 'Your account is  Diactivated!'
            ], 403);
        }



        // Regenerate session to prevent session fixation
        $request->session()->regenerate();
        session(['author_id' => $author->id, 'author_name' => $author->name]);
        // Return success response
        return response()->json([
            'status'  => true,
            'message' => 'Login successful',
            'author'  => $author
        ], 200);
    }

    // logout

    public function logout(Request $request)
    {
        // Logout the author
        Auth::guard('author')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    public function forgotauthorpassword(Request $request)
    {

        $request->validate(['email' => 'required|email']);

        $author = Author::where('email', $request->email)->first();

        if (!$author) {
            return response()->json(['message' => 'Email does not exist'], 404);
        }

        if ($author->status == 0) {
            return response()->json(['message' => 'You are not authenticated by admin'], 403);
        }

        if ($author->status == 3) {
            return response()->json(['message' => 'You are not Diactivated by admin'], 403);
        }

        // Generate 6 digit random token
        $token = rand(100000, 999999);

        $author->token = $token;
        $author->token_created_at = now(); // timestamp saved
        $author->save();

        $toEamil = $author->email;
        $name = $author->name;
        $tokens = $author->token;




        Mail::to($toEamil)->send(new ResetLinKmail($toEamil, $name, $tokens));




        return response()->json(['message' => 'Reset link sent to your email']);
    }


    public function resetauthorpassword(Request $request)
    {

        // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:authors,email',
            'token' => 'required|digits:6', // token max 6 digits
            'password' => 'required|string|min:6|confirmed', // password_confirmation field also required
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }


        $author = Author::where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$author) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid email or token.'
            ], 400);
        }

        $expiryMinutes = 2; // set how many minutes the token is valid (change to 2 if you need 2)
        if (!$author->token_created_at || $author->token_created_at->addMinutes($expiryMinutes)->isPast()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token has expired.'
            ], 400);
        }

        // Update password and reset token
        $author->password = Hash::make($request->password);
        $author->token = 0;
        $author->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password has been reset successfully.'
        ]);
    }
}
