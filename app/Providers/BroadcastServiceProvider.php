<?php

namespace App\Providers;

use App\User;
use \Auth;
use App\Message;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
   
    public function boot()
    {
        Broadcast::routes();

        // require base_path('routes/channels.php');
        Broadcast::channel('messages.{id}', function ($user, $id) {
            // dd($user->id, $id);
            return  $user->id === (int) $id;

            // $userID = Auth::user()->id;
            // $id = $this->message->to;
            // dd($userID, $id, $user->id);
            // return $userID === $id;
            // dd($userID);
            // dd($userID, $id);
            // return $userID === (int) $id;
            // return true;
            // return  $user->id === (int) $id;
        
            // $userID = Auth::user()->id;
            // dd($user->id, $id);
            // // $userID = Auth::user()->id; 
            // // return $userID === (int) $id;
            // return $user->id === (int) $id;
                //  $userID = Auth::user()->id;
                //     dd($userID, $id);
                //     return $userID === (int) $id;
         
        });
        
    }
}
