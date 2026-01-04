<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthorprofileController extends Controller
{
    public function showauthorprofile()
    {
        if (Auth::guard('author')->check()) {
            $author = Auth::guard('author')->user();

            // find by id
            $data = Author::find($author->id);

            return view('adminpaneal.dashboards.authorprofile', compact('data'));
        }

        return redirect()->route('openautherlogin')
            ->with('error', 'You must login first.');
    }


    public function changePassword(Request $request, $id)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'password' => 'required|min:6|confirmed',
            ],

        );


        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()->all(),
            ], 401);
        }

        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                'status' => false,
                'message' => 'Author not found.'
            ], 404);
        }

        $author->password = Hash::make($request->password);
        $author->save();

        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully.'
        ], 200);
    }

    public function changeautherimage($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'message' => 'Author not found',
                'data' => null
            ], 404);
        }

        // If no image saved, return default
        $image = $author->image ? $author->image : 'default.png';

        return response()->json([
            'message' => 'Author image fetched successfully',
            'data' => [
                'image' => $image
            ]
        ]);
    }

   
   public function updateauthorimage(Request $request, $id)
{
    // Validate input
    $validateimage = Validator::make(
        $request->all(),
        [
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]
    );

    if ($validateimage->fails()) {
        return response()->json([
            'status'  => false,
            'message' => 'Validation error',
            'errors'  => $validateimage->errors()->all(),
        ], 422);
    }

    // Find author
    $author = Author::findOrFail($id);

    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($author->image && file_exists(public_path('uploads/' . $author->image))) {
            unlink(public_path('uploads/' . $author->image));
        }

        // Save new image
        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);

        // Update author record
        $author->image = $filename;
        $author->save();
    }

    return response()->json([
        'status'  => true,
        'message' => 'Image updated successfully',
        'data'    => [
            'image' => $author->image
        ]
    ]);
}

}
