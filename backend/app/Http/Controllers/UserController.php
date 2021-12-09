<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use SebastianBergmann\Environment\Console;

class UserController extends Controller
{
    public function cadastro(Request $request)
    {
        $data = $request->all();

        $validation = Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validation->fails()) {
            return [
                'success' => false,
                'errors' => $validation->errors(),
                'message' => 'Erro de Validação'
            ];
        }

        $image = "/profiles/profile-placeholde.jpg";

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'image'    => $image
        ]);

        $user->token = $user->createToken($user->email)->accessToken;

        return [
            'success' => true,
            'data' => $user,
            'message' => 'Perfil atualizado com sucesso'
        ];
        return $user;
    }
    public function login(Request $request)
    {
        sleep(1);

        $data = $request->all();

        $validation = Validator::make($data, [
            'email'    => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return [
                'success' => false,
                'errors' => $validation->errors(),
                'message' => 'Erro de Validação'
            ];
        }

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $user = auth()->user();
            $user->token = $user->createToken($user->email)->accessToken;

            return [
                'success' => true,
                'data' => $user,
                'message' => 'Login com sucesso'
            ];
            return $user;
        } else {
            return [
                'success' => false,
                'message' => 'Login Inválido',

            ];
        }

    }

    public function settings(Request $request)
    {
        $user = $request->user();
        $data = $request->all();

        if (isset($data['password'])) {
            $validation = Validator::make($data, [
                'name'     => ['required', 'string', 'max:255'],
                'email'    => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id)
                ],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            if ($validation->fails()) {
                return [
                    'success' => false,
                    'errors' => $validation->errors(),
                    'message' => 'Erro de Validação'
                ];
            }

            $user->password = Hash::make($data['password']);
        } else {
            $validation = Validator::make($data, [
                'name'  => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id)
                ]
            ]);

            if ($validation->fails()) {
                return [
                    'success' => false,
                    'errors' => $validation->errors(),
                    'message' => 'Erro de Validação'
                ];
            }

            $user->name = $data['name'];
            $user->email = $data['email'];
        }

        if (isset($data['image'])) {

            Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
                $explode = explode(',', $value);
                $allow = ['png', 'jpg', 'svg','jpeg'];
                $format = str_replace(
                    [
                        'data:image/',
                        ';',
                        'base64',
                    ],
                    [
                        '', '', '',
                    ],
                    $explode[0]
                );
                // check file format
                if (!in_array($format, $allow)) {
                    return false;
                }
                // check base64 format
                if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                    return false;
                }
                return true;
            });

            $validation = Validator::make($data, [
                'image' => 'base64image',

            ],['base64image'=>'Imagem inválida']);

            if($validation->fails()){
              return [
                'success' => false,
                'errors' => $validation->errors(),
                'message' => 'Imagem inválida'
            ];
            }

            $time = time();
            $parentDirectory = 'profiles';
            $imageDirectory = $parentDirectory . DIRECTORY_SEPARATOR . 'profile_id' . $user->id;
            $ext = substr($data['image'], 11, strpos($data['image'], ';') - 11);
            $urlImage = $imageDirectory . DIRECTORY_SEPARATOR . $time . '.' . $ext;

            $file = str_replace('data:image/' . $ext . ';base64,', '', $data['image']);
            $file = base64_decode($file);

            if (!file_exists($parentDirectory)) {
                mkdir($parentDirectory, 0700);
            }
            if ($user->image) {
                $imgUser = str_replace(asset('/'), '', $user->image);

                if (    file_exists($imgUser)) {
                    unlink($imgUser);
                }
            }

            if (!file_exists($imageDirectory)) {
                mkdir($imageDirectory, 0700);
            }

            file_put_contents($urlImage, $file);

            $user->image = $urlImage;

        }

        $user->save();
        $user->token = $user->createToken($user->email)->accessToken;

        return [
            'success' => true,
            'data' => $user,
            'message' => 'Perfil atualizado com sucesso'
        ];

    }

    public function friend(Request $request)
    {
        $user = $request->user();
        $friend = User::find($request->id);

        if ($friend && ($user->id != $friend->id)) {
            $user->friends()->toggle($friend->id);
            return [
                'success' => true,
                'data' => $user->friends,
                'message' => 'Amigo adicionado'
            ];
        } else {
            return [
                'success' => false,
                'errors' => 'Usuário inexistente'
            ];
        }
    }

    public function friendsList(Request $request){
        $user = $request->user();
        if ($user) {
            return [
                'success' => true,
                'data' => $user->friends,
                'message' => 'Lista de Amigos'
            ];
        } else {
            return [
                'success' => false,
                'errors' => 'Usuário inexistente'
            ];
        }
    }
    public function friendsListProfile($id, Request $request){
        $userProfile = User::find($id);
        $logged = $request->user();
        if ($userProfile) {
            return [
                'success' => true,
                'data' => [
                    'friends' => $userProfile->friends,
                    'friendsLogged' => $logged->friends,
                 ],
                'message' => 'Lista de Amigos'
            ];
        } else {
            return [
                'success' => false,
                'errors' => 'Usuário inexistente'
            ];
        }
    }
}
