<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Helpers\JwtAuth;
use App\Post;

class PostController extends Controller {

    public function index() {
        $post = Post::all()->load('user')->load('section');
        return response()->json(array(
                    'items' => $post,
                    'status' => 200
                        ), 200);
    }

    public function store(Request $request) {
        $hash = $request->header('Authotization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);
        if ($checkToken) {
            //recoger datos por post
            $json = $request->input('json', null);
            $params = json_decode($json);
            $params_array = json_decode($json, true);
            //conseguir el usuario identificado
            $user = $jwtAuth->checkToken($hash, true);

            $post = new Post();

            $post->user_id = $user->sub;
            $post->num = $params->num;
            $post->title = $params->title;
            $post->section_id = $params->section_id;
            $post->link_text = $params->link_text;
            $post->link = $params->link;
            $post->description = $params->description;
            $post->status = $params->status;
            $post->save();
            $data = array(
                'post' => $post,
                'status' => 'success',
                'code' => 200
            );
        } else {
            //Devolver error
            $data = array(
                'message' => 'Login incorrecto',
                'status' => 'error',
                'code' => 300
            );
        }
        return response()->json($data, 200);
    }

    public function upload(Request $request) {
        $path = 'image';
        $files = $request->files->all();
        //$nombre=array_values($files)[0]->getClientOriginalName();
        $id = key($files);
        $nombre = $id . "." . array_values($files)[0]->getClientOriginalExtension();
        //$message = $nombre;
        array_values($files)[0]->move($path, $nombre);
        Post::where('id', $id)->update(['image' => $path . "/" . $nombre]);
        $data = array(
            //'message' => $message,
            'status' => 'success',
            'code' => 200
        );
        return response()->json($data, 200);
    }

    public function update(Request $request) {

        $json = $request->input('json', null);
        $hash = $request->header('Authotization', null);
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($hash);
        if ($checkToken) {
            //recoger datos por post
            $json = $request->input('json', null);
            $params = json_decode($json);
            //  $params_array = json_decode($json, true);
            //conseguir el usuario identificado
            $user = $jwtAuth->checkToken($hash, true);
            $id = $params->id;
            Post::where('id', $id)
                    ->update([
                        'user_id' => $user->sub,
                        'num' => $params->num,
                        'title' => $params->title,
                        'section_id' => $params->section_id,
                        'link_text' => $params->link_text,
                        'link' => $params->link,
                        'description' => $params->description,
                        'status' => $params->status,
                        'user_id' => $user->sub
            ]);
            $post = Post::where('id', $id);
            $data = array(
                'post' => $post,
                'status' => 'success',
                'code' => 200
            );
        } else {
            //Devolver error
            $data = array(
                'message' => 'Login incorrecto',
                'status' => 'error',
                'code' => 300
            );
        }
        return response()->json($data, 200);
    }

}
