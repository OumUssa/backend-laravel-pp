<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'price',
        'image_url',
        'user_id',
        'type_product_id',
        'pet_category_id'
    ];

    public function productTypes(){
        return $this->belongsTo(TypeProduct::class);
    }

    public function petCategories(){
        return $this->belongsTo(PetCategory::class);
    }
}
