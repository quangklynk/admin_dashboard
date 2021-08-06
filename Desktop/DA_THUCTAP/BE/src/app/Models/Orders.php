<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    public function status() {
        return $this->belongsTo(Status::class, 'idStatus', 'id');
    }

    public function detailOrder(){
        return $this->hasMany(Detail_Order::class, 'idOrder', 'id');
    }
}
