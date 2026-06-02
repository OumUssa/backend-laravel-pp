<?php

namespace App\Http\Controllers;

use App\Models\PetCategory;
use Illuminate\Http\Request;

class PetCategoryController extends Controller
{
    //
    public function getPetCategories(){
        $petCategory = PetCategory::all();
        return response()->json(
            $petCategory
        );
    }

    public function addPetCategories(Request $request){
        $validated = $request->validate([
            'name'=> 'required|string|max:100'
        ]);

        $petCategory = PetCategory::create($validated);

        return response()->json([
            'message' => 'Pet category created successfully',
            'pet_categories' => $petCategory
        ], 201);
    }
}
