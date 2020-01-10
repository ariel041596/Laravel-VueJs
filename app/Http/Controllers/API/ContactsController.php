<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Message;
use \Auth;
use App\Events\NewMessage;

class ContactsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function get(){

        // get all users except the authenticated one
        $currentUserID = Auth::user()->id;
        $contacts = User::where('id', '!=', $currentUserID)->get();

        $unreadIDs = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
        ->where('to', Auth::user()->id)
        ->where('read', false)
        ->groupBy('from')
        ->get();

        $contacts = $contacts->map(function($contact) use ($unreadIDs){
            $contactUnread = $unreadIDs->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

            return $contact; 
        });

        return response()->json($contacts);

    }
    public function getMessagesFor($id){
        // $messages = Message::where('from', $id)->orWhere('to', $id)->get();

        Message::where('from', $id)->where('to', Auth::user()->id)->update(['read' => true]);
        
        $messages = Message::where(function($q) use ($id) {
            $userID = Auth::user()->id;
            $q->where('from', $userID);
            $q->where('to', $id);
        })->orWhere(function($q) use($id) {
            $userID = Auth::user()->id;
            $q->where('from', $id);
            $q->where('to', $userID);
        })->get(); //This query is (a = 1 and b = 2 || c = 1 and d = 2 )
        return response()->json($messages);
        
    }
    public function getUserObject(){
        // $user = Auth::user();
        // return response()->json($user);
        // return Auth::user();
    }
    public function getID(){
        $userID = Auth::user()->id;
        return response()->json($userID);
    }
    public function send(Request $request){
        $from = Auth::user()->id;
        $message = Message::create([
            'from' => $from,
            'to' => $request->contact_id,
            'message' => $request->message
        ]);

        // Start of Pusher
        broadcast(new NewMessage($message));
        
        return response()->json($message);
    }
}
