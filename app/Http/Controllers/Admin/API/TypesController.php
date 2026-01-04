<?php

namespace App\Http\Controllers\Admin\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\String_;

use function PHPSTORM_META\type;

class TypesController extends Controller
{
    public function showtypes()
    {
        $data = type::get();

        return view('adminpaneal.dashboards.types', compact('data'));
    }

    public function addtype(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ['name' => 'required|string']
        );

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $type = Type::create(['name' => $request->name]);

        return response()->json([
            'status'  => true,
            'message' => 'Add New Type Successfully',
            'data'    => ['type' => $type->name]
        ]);
    }


    public function showtyp(String $id)
    {
        $data = Type::where('id', $id)->first();

        return response()->json(['message' => 'data fetched successfully', 'data' => $data]);
    }

    public function updatetypes(Request $request, String $id)
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



        $type = Type::findOrFail($id);


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



    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();

        return response()->json(['message' => 'Type deleted successfully']);
    }
}
