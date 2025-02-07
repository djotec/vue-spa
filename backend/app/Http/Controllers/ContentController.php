<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use App\User;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\elementType;

class ContentController extends Controller
{
    public function list(Request $request)
    {
        // $contents = Content::with(['user'])->orderBy('posted_at', 'DESC')->paginate(5);
        $user = $request->user();

        $friends = $user->friends->pluck('id');
        $friends->push($user->id);
        $contents = Content::wherein('user_id', $friends)->with(['user'])->orderBy('posted_at', 'DESC')->paginate(5);

        foreach ($contents as $content) {
            $content->total_likes = $content->likes()->count();
            $content->comments = $content->comments()->with('user')->get();
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
    public function profile($id, Request $request)
    {
        $owner = User::find($id);

        if ($owner){
            $contents = $owner->contents()->with(['user'])->orderBy('posted_at', 'DESC')->paginate(5);
            // $contents = Content::with(['user'])->orderBy('posted_at', 'DESC')->paginate(5);
            $user = $request->user();
            foreach ($contents as $content) {
                $content->total_likes = $content->likes()->count();
                $content->comments = $content->comments()->with('user')->get();
                // $content->comments = $content->comments;
                $iLikedThis = $user->likes()->where('id', $content->id)->exists();

                $content->i_liked_this = $iLikedThis;
            }

            return [
                'success' => true,
                'data' => [
                    'contents' => $contents,
                    'owner' => $owner],
                'message' => 'Lista de Conteúdos'
            ];

        } else{
            return [
                'success' => false,
                'errors' => 'Usuário não existe'
            ];

        }


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
    public function likeProfile($id, Request $request)
    {
        $content = Content::find($id);
        if($content){
            $user = $request->user();
            $user->likes()->toggle($content->id);
            return [
                'success' => true,
                'data' => [
                    'total_likes' => $content->likes()->count(),
                    'contents' => $this->profile($content->user_id, $request),
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
    public function comment($id, Request $request)
    {
        $content = Content::find($id);
        if($content){
            $user = $request->user();

            $user->comments()->create([
                'content_id' => $content->id,
                'text' => $request->text,
                'posted_at' => date('Y-m-d H:i:s')
            ]);

            return [
                'success' => true,
                'data' => $this->list($request),
                'message' => 'Comment added'
            ];

        } else{
            return [
                'success' => false,
                'errors' => 'Conteúdo não existe'
            ];
        }
    }
    public function commentProfile($id, Request $request)
    {
        $content = Content::find($id);
        if($content){
            $user = $request->user();

            $user->comments()->create([
                'content_id' => $content->id,
                'text' => $request->text,
                'posted_at' => date('Y-m-d H:i:s')
            ]);

            return [
                'success' => true,
                'data' =>  $this->profile($content->user_id,$request),
                'message' => 'Comment added'
            ];

        } else{
            return [
                'success' => false,
                'errors' => 'Conteúdo não existe'
            ];
        }
    }

    public function delete($id, Request $request)
    {
        $content = Content::find($id);
        if($content){
            $content->delete($id);
            return [
                'success' => true,
                'data' => $this->list($request),
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


