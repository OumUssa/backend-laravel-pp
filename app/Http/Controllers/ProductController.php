<?php

namespace App\Http\Controllers;

use App\Models\PetCategory;
use App\Models\Product;
use App\Models\TypeProduct;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //show all products belong to all users
    public function getAllProducts(){
        $products = Product::with(['user', 'petCategory', 'productType'])->get();
        return response()->json($products);
    }

    //show all products belong to specific user
    public function getProductsFromAUser(Request $request){
        $products = Product::with(['user', 'petCategory', 'productType'])->where('user_id', $request->user()->id)->get();
        return response()->json($products);
    }


    //add product
    public function addProducts(Request $request){

        //request validation
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image_url' => 'required|string',
            'pet_category_name' => 'required|string',
            'product_type_name' => 'required|string',
        ]);

        //get authenticated user
        $user = $request->user();
        //get pet category
        $pet_category = PetCategory::where('name', $validated['pet_category_name'])->first();
        //get product type
        $product_type = TypeProduct::where('name', $validated['product_type_name'])->first();

        // Check if user is admin (role_id == 2)
        if ($user->role_id != 2 && $user->role_id != 1) {
            return response()->json([
                'result' => false,
                'msg' => 'Unauthorized. Only admins can create products.'
            ], 403);
        }

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

    //update product
    public function updateProduct(Request $request, $product_name){
        //request(new data) validation
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image_url' => 'required|string',
            'pet_category_name' => 'required|string',
            'product_type_name' => 'required|string',
        ]);

        $user = $request->user();
        $product = Product::where('title', $product_name)->where('user_id', $user->id)->first();

        //if product not found
        if (!$product) {
            return response()->json([
                'result' => false,
                'msg' => 'Product not found'
            ], 404);
        }

        //get product type
        $product_type = TypeProduct::where('name', $validated['product_type_name'])->first();
        $pet_category = PetCategory::where('name', $validated['pet_category_name'])->first();

        if(!$product_type || !$pet_category){
            return response()->json([
                'result' => false,
                'msg' => 'Invalid product type or pet category'
            ], 404);
        }

        //update the product
        $product->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image_url' => $validated['image_url'],
            'user_id' => $user->id,
            'type_product_id' => $product_type->id,
            'pet_category_id' => $pet_category->id
        ]);

        return response()->json([
            'result' => true,
            'msg' => 'Product updated successfully',
            'data' => $product
        ]);
    }

    //delete product
    public function deleteProduct(Request $request, $product_name){
        $user = $request->user();
        $product = Product::where('title', $product_name)->where('user_id', $user->id)->first();

        //if product not found
        if (!$product) {
            return response()->json([
                'result' => false,
                'msg' => 'Product not found'
            ], 404);
        }   

        $product->delete();
        return response()->json([
            'result' => true,
            'msg' => 'Product deleted successfully',
        ]);
    }

    //get a single product details
    public function getProduct($id)
    {
        $product = Product::with(['user', 'petCategory', 'productType'])->find($id);

        if (!$product) {
            return response()->json([
                'result' => false,
                'msg' => 'Product not found'
            ], 404);
        }

        return response()->json($product);
    }
}

    
    

