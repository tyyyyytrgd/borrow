<?php

namespace App;

use Illuminate\Foundation\Auth\User as Model;

class Admin extends Model
{
    //
    protected $guarded = ['id'];
    protected $hidden = ['password','remember_token'];

    public function getAuthPassword(){
        return $this->password;
    }

}
