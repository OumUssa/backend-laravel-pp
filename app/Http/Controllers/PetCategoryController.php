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

    public function updatePetCategory(Request $request, $id){
        $validated = $request->validate([
            'name'=> 'required|string|max:100'
        ]);

        $petCategory = PetCategory::find($id);
        if (!$petCategory) {
            return response()->json(['message' => 'Pet category not found'], 404);
        }

        $petCategory->update($validated);

        return response()->json([
            'result' => true,
            'message' => 'Pet category updated successfully',
            'pet_category' => $petCategory
        ]);
    }

    public function destroy($id)
    {
        $petCategory = PetCategory::find($id);

        if (!$petCategory) {
            return response()->json([
                'result' => false,
                'message' => 'Pet category not found'
            ], 404);
        }

        $petCategory->delete();

        return response()->json([
            'result' => true,
            'message' => 'Pet category deleted successfully'
        ]);
    }
}
