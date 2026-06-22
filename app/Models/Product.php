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

    public function productType(){
        return $this->belongsTo(TypeProduct::class, 'type_product_id');
    }

    public function petCategory(){
        return $this->belongsTo(PetCategory::class, 'pet_category_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function purchase(){
        return $this->hasMany(Purchase::class);
    }
}
