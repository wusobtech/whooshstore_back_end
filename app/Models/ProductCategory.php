<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    public $guarded = [];

    public function products(){
        return $this->hasMany(Product::class , "category_id");
    }

    public function sub_categories(){
        return $this->hasMany(ProductCategory::class , "parent_id" , "id");
    }
}
