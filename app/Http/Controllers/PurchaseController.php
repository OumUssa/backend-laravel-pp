<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    //
    //make purchases
    public function purchaseProduct(Request $request){
        $validated = $request->validate([
            'product_name' => 'required|string',
            'quantity' => 'required|integer',
            'total_price' => 'required|numeric'
        ]);

        //get user id
        $user = $request->user();
        //get product
        $product = Product::where('title', $validated['product_name'])->first();

        //if no products
        if(!$product){
            return response()->json([
                'msg' => 'Product not found'
            ], 404);
        }

        //calculate total on the server
        $total_price = $validated['quantity'] * $product->price;

        $purchase = Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'total_price' => $total_price
        ]);

        return response()->json([
            'msg' => 'Your purchase has been successfully processed',
            'purchase' => $purchase
        ]);

    }

    //get purchase history
    public function showUserPurchases(Request $request){
        $purchases = $request->user()->purchases()->with('product')->get();

        if(!$purchases){
            response()->json([
                'msg' => 'Purchases not found'
            ]);
        }

        return response()->json($purchases);
    }

    //get purchase history for admin
    public function showAdminUserPurchases(Request $request, $id){
        $user = $request->user();
        if ($user->role_id != 1 && strtolower($user->email) !== 'admin@petstore.com') {
            return response()->json(['msg' => 'Unauthorized'], 403);
        }

        $purchases = Purchase::where('user_id', $id)->with('product')->get();

        return response()->json($purchases);
    }
}
