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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'apiAuth', 'prefix' => 'v1'], function () {
    Route::get('classes/created', 'VirtualClassController@getCreatedClasses');
    Route::get('classes/joined', 'VirtualClassController@getJoinedClasses');
    Route::get('classes/{classGuid}/join', 'VirtualClassController@joinClass');
    Route::get('classes/{classGuid}/left', 'VirtualClassController@leftClass');
    Route::get('classes/{classGuid}', 'VirtualClassController@show');
    Route::resource('classes', 'VirtualClassController');

    Route::get('me/posts', 'AppUserController@getPosts');
    Route::get('me/classmates', 'AppUserController@getClassmates');
    Route::get('me', 'AppUserController@show');
    Route::post('me', 'AppUserController@update');
    Route::post('me/profilepicutre', 'AppUserController@uploadProfilePic');
    Route::delete('me', 'AppUserController@destroy');

    Route::get('posts/{postId}/likers', 'PostController@getLikers');
    Route::get('posts/{postId}/comments', 'CommentController@index');
    Route::post('posts/{postId}/addcomment', 'CommentController@store');
    Route::get('posts/{postId}/addview', 'PostController@addView');
    Route::get('posts/{postId}/unlike', 'PostController@unlike');
    Route::get('posts/{postId}/like', 'PostController@like');
    Route::get('posts/created', 'PostController@getUserCreatedPosts');
    Route::get('posts/class/{classId}', 'PostController@getPostsOfClass');
    Route::get('posts/{guid}', 'PostController@show');
    Route::resource('posts', 'PostController');


    Route::delete('comments/{postId}', 'CommentController@destroy');

    Route::resource('files', 'FileController');

    Route::get('classbackgrounds', 'ClassBackgroundController@index');
    Route::get('organizations', 'OrganizationController@index');
    Route::get('accesses', 'AccessController@index');
    Route::get('categories', 'CategoryController@index');
    Route::get('roles', 'RoleController@index');
    Route::get('statuses', 'StatusController@index');
    Route::get('filetypes', 'FileTypeController@index');

});
