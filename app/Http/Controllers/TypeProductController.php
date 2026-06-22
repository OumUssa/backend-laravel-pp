<?php

namespace App\Http\Controllers;

use App\Models\TypeProduct;
use Illuminate\Http\Request;

class TypeProductController extends Controller
{
    //
    public function getProductionTypes(){
        $productTypes = TypeProduct::all();
        return response()->json($productTypes);
    }

    public function addProductType(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $productType = TypeProduct::create($validated);

        return response()->json([
            'message'=> 'Product type has been created successfully',
            'product_type' => $productType
        ], 201);
    }

    public function updateProductType(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $productType = TypeProduct::find($id);
        if (!$productType) {
            return response()->json(['message' => 'Product type not found'], 404);
        }

        $productType->update($validated);

        return response()->json([
            'result' => true,
            'message' => 'Product type updated successfully',
            'product_type' => $productType
        ]);
    }

    public function destroy($id)
    {
        $productType = TypeProduct::find($id);

        if (!$productType) {
            return response()->json([
                'result' => false,
                'message' => 'Product type not found'
            ], 404);
        }

        $productType->delete();

        return response()->json([
            'result' => true,
            'message' => 'Product type deleted successfully'
        ]);
    }
}
