<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    public function list(Request $request){
        $contents = Content::with('user')->orderBy('posted_at', 'DESC')->paginate(5);

        return [
            'success' => true,
            'data' => $contents,
            'message' => 'Lista de Conteúdos'
        ];
    }
    public function add(Request $request)
    {
        $data = $request->all();
        $user = $request->user();

        //validation
        $validation = Validator::make($data, [
            'image' => ['required'],
        ]);


        if ($validation->fails()) {
            return [
                'success' => false,
                'errors' => $validation->errors(),
                'message' => 'Erro de Validação'
            ];
        }


        $content = new Content();
        $content->text  = $data['text'];
        $content->image = $data['image'];
        $content->link  = $data['link'];
        $content->posted_at  = date('Y-m-d H:i:s');

        $user->contents()->save($content);

        $contents = Content::with('user')->orderBy('posted_at', 'DESC')->paginate(5);

        return [
            'success' => true,
            'data' => $contents,
            'message' => 'Lista de Conteúdos'
        ];

    }

    public function delete($id)
    {
        $content = Content::find($id);

        $content->delete();

        return [
            'success' => true,
            'data' => null,
            'message' => 'Lista de Conteúdos'
        ];
    }
}


