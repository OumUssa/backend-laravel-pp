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
}
