<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail_Order extends Model
{
    public function order() {
        return $this->belongsTo(Orders::class, 'idOrder', 'id');
    }
}
