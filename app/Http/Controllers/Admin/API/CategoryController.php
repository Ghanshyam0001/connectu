<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function showcategorytype()
    {
        $data = Category::get();

            return view('adminpaneal.dashboards.category', compact('data'));
    }

    public function addctype(Request $request)
{
    $validator = Validator::make(
        $request->all(),
        ['name' => 'required']
    );

   
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

    $type = Category::create(['name' => $request->name]);

    return response()->json([
        'status'  => true,
        'message' => 'Add New Type Successfully',
        'data'    => ['type' => $type->name]
    ]);
}


    public function showctyp(String $id)
    {
        $data = Category::where('id', $id)->first();

        return response()->json(['message' => 'data fetched successfully', 'data' => $data]);
    }

    public function updatectypes(Request $request, String $id)
    {
        // Validate input
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required'
            ]
        );

         if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $type = Category::findOrFail($id);


        $type->name = $request->name;
        $type->save();


        return response()->json([
            'status'  => true,
            'message' => 'Image updated successfully',
            'data'    => [
                'type' => $type->name
            ]
        ]);
    }



    public function cdestroy($id)
    {
        $type = Category::findOrFail($id);
        $type->delete();

        return response()->json(['message' => 'Type deleted successfully']);
    }
}
