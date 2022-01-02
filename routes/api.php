<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('register', 'UserController@addUser');
Route::post('user_login', 'UserController@userLogin');
Route::get('users', 'UserController@getData');
Route::post('save_or_change_user_avatar', 'UserController@saveOrChangeUserAvatar');
Route::post('checkedAvatarIsNotNullAndView', 'UserController@checkedAvatarIsNotNullAndView');

Route::get('shows', 'ShowController@getData');
Route::post('post', 'ShowController@postData');
Route::post('change_rate_checked', 'ShowController@changeRateChecked');


Route::post('reviews', 'ReviewController@getData');
Route::post('postreview', 'ReviewController@postData');
Route::post('show_review_in_alerts', 'ReviewController@showReviewInAlerts');

Route::get('tags', 'TagController@getData');
Route::post('tags_search', 'TagController@tagsSearch');

Route::post('likes', 'LikeController@getData');
Route::post('checked_current_user_have_alerts', 'LikeController@checkedCurrentUserHaveAlerts');
Route::post('user_like_this_review', 'LikeController@userLikeThisReview');
Route::post('hide_this_alert', 'LikeController@hideThisAlert');
Route::post('load_likes_for_this_user', 'LikeController@loadLikesForThisUser');
Route::post('reviews_update_like_counter', 'LikeController@reviewsUpdateLikeCounter');
Route::post('refresh_user_click_like', 'LikeController@refreshUserClickLike');

Route::post('send_message_to_chat', 'ChatController@sendMessageToChat');
Route::post('download_message_to_chat', 'ChatController@downloadMessageToChat');



