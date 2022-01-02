<?php

namespace App\Http\Controllers;

use App\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{

    public function sendMessageToChat(Request $request) {
        $chat = new Chat;
        $chat->user_req = $request->user_req;
        $chat->user_resp = $request->user_resp;
        $chat->message = $request->chatField;
        $chat->date = date("Y-m-d H:i:s");
        $chat->save();

        return response()->json(['message' => $request->chatField, 'date' => date("Y-m-d H:i:s")]);
    }

    public function downloadMessageToChat(Request $request) {

        $userIsActive = false;

        $data = Chat::all();
          foreach ($data as $chat) {
            if($chat->user_resp == $request->user_resp || $chat->user_req == $request->user_resp) {
                $userIsActive = true;
            }
        }

        if($userIsActive == true) {
        $chat_history = DB::table('chats')
               ->where(array('user_req' => $request->user_req, 'user_resp' => $request->user_resp)) 
               ->orWhere(array('user_req' => $request->user_resp, 'user_resp' => $request->user_req))
               ->select('message', 'user_req')
               ->get();  

               if($chat_history != null ) {
                  return response()->json(['chat_history' => $chat_history, 'isHistory' => true, 'userIsActive' => $userIsActive]);
               }    
        }   
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
