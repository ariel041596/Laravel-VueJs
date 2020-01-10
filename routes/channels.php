<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Broadcast::channel('App.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// use App\User;
// use Illuminate\Support\Facades\Auth;
Broadcast::channel('messages.{id}', function ($user, $id) {
    // dd($user->id, $id);
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
