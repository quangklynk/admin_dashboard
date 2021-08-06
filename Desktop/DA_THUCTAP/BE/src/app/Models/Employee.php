<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'id', 'name', 'address', 'gender','image','idUser',
    ];

    public function blog(){
        return $this->hasMany(Blog::class, 'idEmployee', 'id');
    }
}
