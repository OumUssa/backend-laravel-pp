<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();

        // Check if user is admin (role_id 1 or 2, based on the requirements)
        if (!in_array($user->role_id, [1, 2])) {
            return response()->json(['result' => false, 'msg' => 'Unauthorized'], 403);
        }

        // Return mock data as requested, or actual counts
        return response()->json([
            "total_users" => User::count(),
            "total_products" => Product::count(),
            "total_purchases" => Purchase::count(),
            "total_revenue" => Purchase::sum('total_price')
        ]);
    }
}
