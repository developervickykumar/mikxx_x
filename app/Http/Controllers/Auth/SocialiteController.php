<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite; 
use Illuminate\Support\Facades\DB; 
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
     try
     {
          $guser=Socialite::driver('google')->stateless()->user();
          
          $user = User::where('email',$guser->email)->first();
           if($user)
           {
            if(!$user->google_id)
            {
              $user->update(['google_id'=>$guser->id]);
            }

            Auth::login($user);
            return redirect('/admin/post');
           }
           else{
               $userData= User::create([
                 'first_name' => $guser->name,
                 'last_name' => $guser->name,
               'email' => $guser->email,
               'password' => Hash::make('Pass@12345'),
               'google_id' => $guser->id,
               'is_admin' => '0',
               ]);
            
            
            
                Auth::login($userData);
                return redirect('/admin/post');
            
               
              
           }
           
           
          
        }
        catch(\Exception $e)
        {
            dd($e->getMessage());
        }
     
   }

   public function githubLogin()
   {
     return Socialite::driver('github')->redirect();
   }

   public function githubHandel()
   {
      try {
        $githubUser = Socialite::driver('github')->stateless()->user();
          //dd($githubUser); 
        $user =User::where('email',$githubUser->email)->first();
        if($user)
        {
       
          if(!$user->github_id)
          {
            $user->update(['github_id'=>$githubUser->id]);

          }
          Auth::login($user);
          return redirect('/admin/post');
        }
        else{
          $userData = User::create([
            'first_name'=>$githubUser->nickname,
            'lest_name'=>$githubUser->nickname,
            'email'=>$githubUser->email,
            'password'=>Hash::make('Pass@123'),
            'is_admin' => '0',
          ]);
          Auth::login($userData);
          return redirect('/admin/post');
        }
         

    } catch (\Exception $e) {
        dd($e->getMessage());
    }
  }
}
