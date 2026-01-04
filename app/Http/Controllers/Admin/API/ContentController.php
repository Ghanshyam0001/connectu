<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ContentController extends Controller
{

    public function allcontent()
    {
        return view('adminpaneal.dashboards.content');
    }
    public function showcontents(Request $request)
    {


        $contents =  Content::with(['author', 'category', 'type'])->latest()->paginate(5);

        return response()->json([
            'status' => true,
            'message' => 'Content list fetched successfully',
            'data' => $contents->items(),
            'pagination' => [
                'current_page' => $contents->currentPage(),
                'last_page' => $contents->lastPage(),
                'per_page' => $contents->perPage(),
                'total' => $contents->total(),
            ]
        ]);
    }


    public function addcontent()
    {

        $contentTypes = Type::orderBy('name')->get();
        $categories   = Category::orderBy('name')->get();

        return view('adminpaneal.dashboards.addcontent', compact('contentTypes', 'categories'));
    }

    public function addnewcontent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'type_id'        => 'required|exists:types,id',
            'author_id'      => 'required|exists:authors,id',
            'category_id'    => 'required|exists:categories,id',
            'image'          => 'required_if:type_id,2|image|mimes:jpg,jpeg,png|max:2048',
            'video'          => 'required_if:type_id,1|mimes:mp4,mov,avi,wmv|max:10240',
        ], [
            // Custom error messages (optional)
            'image.required_if' => 'Image is required when content type is Post.',
            'video.required_if' => 'Video is required when content type is Video.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }

        $slug = Str::slug($request->title);

        $imagePath = null;
        $videoPath = null;

        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $imageName = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads/images'), $imageName);
            $imagePath = 'uploads/images/' . $imageName;
        }

        if ($request->hasFile('video')) {
            $vid = $request->file('video');
            $videoName = time() . '.' . $vid->getClientOriginalExtension();
            $vid->move(public_path('uploads/videos'), $videoName);
            $videoPath = 'uploads/videos/' . $videoName;
        }


        $content = Content::create([
            'title'           => $request->title,
            'description'     => strip_tags($request->description),
            'slug'            => $slug,
            'author_id'       => $request->author_id,
            'category_id'     => $request->category_id,
            'type_id'          => $request->type_id,
            'image'           => $imagePath,
            'video'           => $videoPath,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Content added successfully',
            'data'    => $content,
        ]);
    }

    // Delete content
    public function deletecontent($id)
    {
        $content = Content::find($id);

        if (!$content) {
            return response()->json([
                'status' => false,
                'message' => 'Content not found'
            ], 404);
        }

        // Delete image/video files if exist
        if ($content->image && file_exists(public_path($content->image))) {
            unlink(public_path($content->image));
        }
        if ($content->video && file_exists(public_path($content->video))) {
            unlink(public_path($content->video));
        }

        $content->delete();

        return response()->json([
            'status' => true,
            'message' => 'Content deleted successfully'
        ]);
    }

    public function viewsingalcontent(string $id)
    {
        $data = Content::with(['author:id,name', 'category:id,name', 'type:id,name'])
            ->select(['id', 'title', 'description', 'slug', 'image', 'video', 'author_id', 'category_id', 'type_id', 'created_at', 'updated_at'])
            ->where('id', $id)
            ->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Content not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Single data fetched successfully',
            'data' => $data
        ]);
    }

    public function singalupdatecontent(String $id)
    {

        $data = Content::with(['author:id,name', 'category:id,name', 'type:id,name'])
            ->select(['id', 'title', 'description', 'slug', 'image', 'video', 'author_id', 'category_id', 'type_id', 'created_at', 'updated_at'])
            ->where('id', $id)
            ->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Content not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Single data fetched successfully',
            'data' => $data,
            'categories' => Category::select('id', 'name')->get(),
            'contentTypes' => Type::select('id', 'name')->get(),
        ]);
    }


    // update contant
    public function updatecontent(Request $request, $id)
{
    $content = Content::find($id);

    if (!$content) {
        return response()->json([
            'status' => false,
            'message' => 'Content not found'
        ], 404);
    }

    $validator = Validator::make($request->all(), [
        'title'       => 'required|string|max:255',
        'description' => 'required|string',
        'type_id'     => 'required|exists:types,id',
        'author_id'   => 'required|exists:authors,id',
        'category_id' => 'required|exists:categories,id',
        // ✅ image and video are optional but validated when present
        'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'video'       => 'nullable|mimes:mp4,mov,avi,wmv|max:10240',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status'  => false,
            'message' => $validator->errors()->first(),
            'errors'  => $validator->errors()
        ], 422);
    }

    $slug = Str::slug($request->title);

    $imagePath = $content->image;
    $videoPath = $content->video;

    // ✅ If type is image post and a new image is uploaded
    if ($request->type_id == 2 && $request->hasFile('image')) {
        if ($content->image && file_exists(public_path($content->image))) {
            unlink(public_path($content->image));
        }
        $img = $request->file('image');
        $imageName = time() . '.' . $img->getClientOriginalExtension();
        $img->move(public_path('uploads/images'), $imageName);
        $imagePath = 'uploads/images/' . $imageName;

        // remove old video if any
        if ($content->video && file_exists(public_path($content->video))) {
            unlink(public_path($content->video));
        }
        $videoPath = null;
    }

    // ✅ If type is video post and a new video is uploaded
    if ($request->type_id == 1 && $request->hasFile('video')) {
        if ($content->video && file_exists(public_path($content->video))) {
            unlink(public_path($content->video));
        }
        $vid = $request->file('video');
        $videoName = time() . '.' . $vid->getClientOriginalExtension();
        $vid->move(public_path('uploads/videos'), $videoName);
        $videoPath = 'uploads/videos/' . $videoName;

        // remove old image if any
        if ($content->image && file_exists(public_path($content->image))) {
            unlink(public_path($content->image));
        }
        $imagePath = null;
    }

    $content->update([
        'title'       => $request->title,
        'description' => strip_tags($request->description),
        'slug'        => $slug,
        'author_id'   => $request->author_id,
        'category_id' => $request->category_id,
        'type_id'     => $request->type_id,
        'image'       => $imagePath,
        'video'       => $videoPath,
    ]);

    return response()->json([
        'status'  => true,
        'message' => 'Content updated successfully',
        'data'    => $content,
    ]);
}

}
