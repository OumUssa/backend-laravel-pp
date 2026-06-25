<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductComment;
use Illuminate\Http\Request;

class ProductCommentController extends Controller
{
    // Get comments for a specific product
    public function index($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['result' => false, 'msg' => 'Product not found'], 404);
        }

        $comments = ProductComment::with('user')->where('product_id', $id)->get();
        return response()->json($comments);
    }

    // Add a comment to a product
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['result' => false, 'msg' => 'Product not found'], 404);
        }

        $user = $request->user();

        $comment = ProductComment::create([
            'user_id' => $user->id,
            'product_id' => $id,
            'comment' => $validated['comment'],
            'rating' => $validated['rating']
        ]);

        return response()->json([
            'result' => true,
            'msg' => 'Comment added successfully',
            'data' => $comment
        ], 201);
    }

    // Delete a comment
    public function destroy(Request $request, $id)
    {
        $comment = ProductComment::find($id);

        if (!$comment) {
            return response()->json(['result' => false, 'msg' => 'Comment not found'], 404);
        }

        $user = $request->user();

        // Check if user is the owner or an admin (role_id 1 or 2)
        $isAdmin = in_array($user->role_id, [1, 2]);

        if ($comment->user_id !== $user->id && !$isAdmin) {
            return response()->json(['result' => false, 'msg' => 'Unauthorized to delete this comment'], 403);
        }

        $comment->delete();

        return response()->json([
            'result' => true,
            'msg' => 'Comment deleted successfully'
        ]);
    }
}
