<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite; 
use Illuminate\Support\Facades\DB; 
use App\Models\UserSocialite;
class SocialiteController extends Controller
{
    /**
     * Function: googleLogin
     * Description: This function will redirect to Google
     * @param NA
     * @return void
     */
   public function googleLogin()
   {
    return Socialite::driver('google')->redirect();
   }
   public function googleHandle()
   {
     try{
          $guser=Socialite::driver('google')->user();
          
          $fin =User::where('email',$user->email);
           if($finduser)
           {
               $finduser = new UserSocialite;
              $finduser->name =$guser->name;
               $finduser->email =$guser->email;
              
               $finduser->password = "123456Dummy";
               
               $finduser->save();
              
              
            
              
           }      
          
     }
     catch(Exception $e)
     {
         dd($e->getMessage);
     }
   }
}
