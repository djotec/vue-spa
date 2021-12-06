<?php

use App\User;
use App\Content;
use App\Comment;
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


Route::post('/cadastro', "UserController@cadastro");
Route::post('/login', "UserController@login");
Route::middleware('auth:api')->put('/settings', "UserController@settings");

Route::middleware('auth:api')->post('/content/add', "ContentController@add");
Route::middleware('auth:api')->get('/content/list', "ContentController@list");
Route::middleware('auth:api')->put('/content/like/{id}', "ContentController@like");
Route::middleware('auth:api')->put('/content/comment/{id}', "ContentController@comment");
Route::middleware('auth:api')->put('/content/delete/{id}', "ContentController@delete");

Route::middleware('auth:api')->get('/content/profile/list/{id}', "ContentController@profile");

Route::middleware('auth:api')->post('/user/friend', "UserController@friend");
// listFriends ListFriendsProfile
Route::middleware('auth:api')->get('/user/friendsList', "UserController@friendsList");
Route::middleware('auth:api')->get('/user/friendsListProfile/{id}', "UserController@friendsListProfile");
Route::get('/tests', function(){
    $user = User::find(6);

    $content = Content::find(31);
    // $user->comments()->create([
    //     'content_id' => $content->id,
    //     'text' => 'Eu sou o Melhor',
    //     'posted_at' => date('Y-m-d')
    // ]);

    return $content->comments;


    /* Add Content
    $user->contents()->create([
        'title' => 'Conteudo 2',
        'text' => 'Texto aqui',
        'image' => 'url image',
        'link' => 'link',
        'posted_at' => date('Y-m-d')
    ]);
    return $user->contents;
    */

    /*Add friends
     $user->friends()->toggle($user2->id);
     return $user->friends;
     */

     /* Add likes
    $content = Content::find(1);
    $user->likes()->toggle($content->id);
    return $user->likes->count();
    return $user->likes;
    */

    /* Add Comments
    $content = Content::find(1);
    $user->comments()->create([
        'content_id' => $content->id,
        'text' => 'Show',
        'posted_at' => date('Y-m-d')
    ]);
    $user2->comments()->create([
        'content_id' => $content->id,
        'text' => 'Cringe',
        'posted_at' => date('Y-m-d')
    ]);
    return $content->comments;
    */

});

