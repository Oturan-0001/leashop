<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'image', 'price'];

    // Cette fonction s'exécute quand on crée un produit
    public static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }
}
