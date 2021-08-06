<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category() {
        return $this->belongsTo(Category::class, 'idCategory', 'id');
    }

    public function listImage(){
        return $this->hasMany(List_Image::class, 'idProduct', 'id');
    }
}
