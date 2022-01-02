<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{


     public function getData(Request $request)
    {

        $likes = DB::table('likes')
               ->where(array('showOrHideUserAlert' => 1, 'user_author' => $request->user_name))
               ->select('id', 'user_like', 'user_author_review')
               ->get();

        return response()->json($likes);  
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userLikeThisReview(Request $request)
    {
  
        $like = new Like;
        $like->user_like = $request->user_like;
        $like->user_author = $request->user_author;
        $like->user_author_review = $request->user_author_review;
        $like->showOrHideUserAlert = $request->showOrHideUserAlert;
        $like->save();

        $likes_reviews = DB::table('reviews')
               ->where(array('user_review' => $request->user_author_review, 'isClick' => true))
               //->select('user_id', 'user_name', 'user_review', 'isClick', 'currentCounter')
               ->get();  

        if ($likes_reviews != null) {
            return response()->json(['resp', true]);
        } return response()->json(['resp', false]);

       // DB::table('reviews')->where('user_review', $request->user_author_review)->update(array('currentCounter' => $request->currentCounter));
      //  return response()->json(['reviews_index' => $reviews_index]);
    }

    public function loadLikesForThisUser(Request $request) {


            DB::table('reviews')
            ->join('likes', 'reviews.user_review', '=', 'likes.user_author_review')
            ->where('likes.user_like', '=', $request->user_name)
            ->update(array('reviews.isClick' => true));

            //return response()->json(['message', $request]);

    }

    public function refreshUserClickLike(Request $request) {
            DB::table('reviews')
            ->join('likes', 'reviews.user_review', '=', 'likes.user_author_review')
            ->where('likes.user_like', '=', $request->user_name)
            ->update(array('reviews.isClick' => false));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkedCurrentUserHaveAlerts(Request $request)
    {
         $likes = Like::all();

            foreach ($likes as $like) {
                if ($like->user_author == $request->user_name) {
                   return true;
                }
            }
    }

    public function hideThisAlert(Request $request) {


        DB::table('likes')->where('id', $request->review_id)->delete();

        $likes = Like::all();
        return $likes;

    }

    public function reviewsUpdateLikeCounter(Request $request) {
        DB::table('reviews')->where('user_review', $request->review)->update(array('currentCounter' => $request->likeCounter));
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
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Like $like)
    {
        //
    }
}
