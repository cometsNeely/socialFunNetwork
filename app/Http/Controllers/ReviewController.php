<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {

         DB::table('reviews')
            ->join('likes', 'reviews.user_review', '=', 'likes.user_author_review')
            ->where('likes.user_like', '=', $request->user_name)
            ->update(array('reviews.isClick' => true));
            
        $show_reviews = DB::table('reviews')
               ->where('show_id', '=', $request->show_id)
               ->select('user_id', 'user_name', 'user_review', 'isClick', 'currentCounter')
               ->get();  

        return response()->json(['reviews' => $show_reviews]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function postData (Request  $request)
    {

        $review = new Review;
        $review->user_id = $request->user_id;
        $review->show_id = $request->show_id;
        $review->user_name = $request->user_name;
        $review->user_review = $request->user_review;
        $review->isClick = false;
        $review->currentCounter = 0;
       /* if ($request->user_rate==null) {
            $review->user_rate = 0;
        } else {
            $review->user_rate = $request->user_rate;
        }*/
        $review->save();
        //return $request->user_review;

        return response()->json($request);
    }

    public function reviewInAlerts(Request $request) {

        $user_review = DB::table('reviews')
               ->where('id', $request->reviewId)
               ->select('user_review')
               ->get();

        return response()->json($user_review);  
        
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
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
