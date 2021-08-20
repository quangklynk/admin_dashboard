<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnterSticker extends Model
{
    public function detailEnterSticker(){
        return $this->hasMany(DetailEnterSticker::class, 'idSticker', 'id');
    }
}
