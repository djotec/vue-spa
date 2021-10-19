<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;

class ContentController extends Controller
{
    public function add(Request $request)
    {
        $data = $request->all();
        $user = $request->user();



        //validation

        $content = new Content();
        $content->text  = $data['text'];
        $content->link  = $data['link'];
        $content->image = $data['image'];
        $content->posted_at  = date('Y-m-d H:i:s');

        $user->contents()->save($content);

        return [
            'success' => true,
            'data' => $user->contents,
            'message' => 'Conteudo adicionado'
        ];



    }
}


