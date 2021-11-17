<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\elementType;

class ContentController extends Controller
{
    public function list(Request $request)
    {
        $contents = Content::with(['user', 'comments'])->orderBy('posted_at', 'DESC')->paginate(5);
        $user = $request->user();

        foreach ($contents as $content) {
            $content->total_likes = $content->likes()->count();
            // $content->comments = $content->comments;
            $iLikedThis = $user->likes()->where('id', $content->id)->exists();

            $content->i_liked_this = $iLikedThis;
        }

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
    public function like($id, Request $request)
    {
        $content = Content::find($id);
        if($content){
            $user = $request->user();
            $user->likes()->toggle($content->id);
            return [
                'success' => true,
                'data' => [
                    'total_likes' => $content->likes()->count(),
                    'contents' => $this->list($request),
                 ],
                'message' => 'Like'
            ];

        } else{
            return [
                'success' => false,
                'errors' => 'Conteúdo não existe'
            ];
        }
    }

    public function delete($id)
    {
        $content = Content::find($id);
        if($content){
            $content->delete($id);
            return [
                'success' => true,
                'data' => null,
                'message' => 'Item deletado'
            ];

        } else{
            return [
                'success' => false,
                'errors' => 'Conteúdo não existe'
            ];
        }
    }
}


