<?php

namespace App\Http\Controllers;

use App\Models\PetCategory;
use App\Models\Product;
use App\Models\TypeProduct;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function getProducts(){
        $products = Product::all();
        return response()->json($products);
    }

    public function addProducts(Request $request){

        //request validation
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image_url' => 'required|string',
            'pet_category_name' => 'required|string',
            'product_type_name' => 'required|string',
            // 'user_id'=> 'required|exists:users,id',
            // 'type_product_id'=> 'required|exists:type_products,id',
            // 'pet_category_id'=> 'required|exists:pet_categories,id',
        ]);

        //get authenticated user
        $user = $request->user();
        //get pet category
        $pet_category = PetCategory::where('name', $validated['pet_category_name'])->first();
        //get product type
        $product_type = TypeProduct::where('name', $validated['product_type_name'])->first();

        //if pet catg & product type are not found
        if(!$pet_category){
            return response()->json([
                'message' => 'Pet category not found'
            ], 404);
        }
        if(!$product_type){
            return response()->json([
                'message' => 'Product type not found'
            ], 404);
        }

        //create product
        $product = Product::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image_url' => $validated['image_url'],
            'user_id' => $user->id,
            'type_product_id' => $product_type->id,
            'pet_category_id' => $pet_category->id
        ]);


        return response()->json([
            'message' => 'Product has been added successfully',
            'product' => $product
        ], 201);
    }
}
