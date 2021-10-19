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
Route::middleware('auth:api')->put('/profile', "UserController@profile");
Route::middleware('auth:api')->post('/content/add', "ContentController@add");

Route::get('/tests', function(){
    $user = User::find(1);
    $user2 = User::find(3);
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

