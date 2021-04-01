<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
class LoginController extends Controller
{
    //
    public  function  showLoginForm() {
        return view('user.login');
    }

    public  function redirectToProvider(){
        return Socialite::driver('google')->redirect();
    }
    public function  handleProviderCallback(){
        try{
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e){
            return redirect('/login');
        }

        $exitingUser = User::where('email',$user->email)->first();
        if ($exitingUser){
            Auth::login($exitingUser, true);
        }else{
            $newUser = User::create([
                'name'=>$user->name,
                'email'=>$user->email,
                'google_id'=>$user->id,
                'password'=>Hash::make('test')
            ]);
            Auth::login($newUser,true);
        }
        return  redirect()->to('/');
    }
}
