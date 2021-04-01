<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    //
public function logout(){
    \Auth::guard('admin')->logout();
     return redirect('/back-office/login');
       }
}
