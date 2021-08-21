<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'id', 'idUser', 'idStatus', 'note', 'address'
    ];

    public function status() {
        return $this->belongsTo(Status::class, 'idStatus', 'id');
    }

    public function detailOrder(){
        return $this->hasMany(Detail_Order::class, 'idOrder', 'id');
    }
}
