<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //
    public function  item(){
        return $this->belongsTo(Item::class);

    }

}
