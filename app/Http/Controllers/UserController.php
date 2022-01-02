<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getData() {

        $data = User::all();
        return $data;
    }

    public function addUser(Request $request)
    {

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->avatar = "/";
        $user->save();
        

       // return response()->json(['avg_rate'=>$avg_rate]);

    }

      public function userLogin(Request $request)
    {

        $users = $this->getData();

        foreach ($users as $user) {
            if($user->email == $request->email && $user->name == $request->name) {
                return response()->json(['message' => true, 'userId' => $user->id]);
            }
        }
        return response()->json(['message' => false]);
    }

    public function saveOrChangeUserAvatar(Request $request) {

            
            $this->validate($request, [
            'file' => 'required|file',
            'user_name' => 'required|string'
            ]);

    
            //$fileExt = $request->file->extension();
            $fileName = $request->file->getClientOriginalName();
            $fileNewName = $fileName;
            $request->file->move('images/', $fileNewName);
            $path = 'images/';

            $newImagePath = $path . $fileNewName;

            //return response()->json(['message' => $newImagePath]);

            $users = $this->getData();
            foreach ($users as $user) {
                if ($user->name == $request->user_name) {
                   DB::table('users')->where('name', $request->user_name)->update(array('avatar' => $newImagePath));
                }
            }
        


    }


    public function checkedAvatarIsNotNullAndView(Request $request) {

          $user_avatar = DB::table('users')
            ->where('name', '=', $request->user_name)
            ->select('avatar')
            ->get();

            //echo $user_avatar;

            return response()->json(['avatar' => $user_avatar]);
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
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
