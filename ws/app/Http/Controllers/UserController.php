<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Helpers\JwtAuth;

class UserController extends Controller {

    public function register(Request $request) {
        //recoger post
        $json = $request->input('json', null); //tomar datos del post, null es la variable por defecto
        $params = json_decode($json);

        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
        $surname = (!is_null($json) && isset($params->surname)) ? $params->surname : null;
        $role = 'ROLE_USER';
        $password = (!is_null($json) && isset($params->password)) ? $params->password : null;

        if (!is_null($email) && !is_null($password) && !is_null($name)) {
            //crear el usuario
            $user = new User();
            $user->email = $email;
            $user->name = $name;
            $user->surname = $surname;
            $user->role = $role;

            $pwd = hash('sha256', $password);
            $user->password = $pwd;

            $isset_user = User::where('email', '=', $email)->first();
            if (count($isset_user) == 0) {
                $user->save();
                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Usuario creado'
                );
            } else {
                $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Usuario duplicado, no puede registrarse'
                );
            }
        } else {
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Usuario no creado'
            );
        }
        return response()->json($data, 200);
    }

    public function login(Request $request) {
        $jwtAuth = new JwtAuth();
        $json = $request->input('json', null);
        $params = json_decode($json);
        $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
        $password = (!is_null($json) && isset($params->password)) ? $params->password : null;
        $getToken = (!is_null($json) && isset($params->getToken )) ? $params->getToken  : true;
        $pwd=hash('sha256',$password);
        if(!is_null($email)&& !is_null($password) && ($getToken==null || $getToken=='false')){
            $signup=$jwtAuth->singup($email, $pwd);
        }elseif ($getToken!=null) {
            $signup=$jwtAuth->singup($email, $pwd,$getToken);
        }else{
            $signup=array(
               'status'=> 'error',
                'message'=>'Envia tus datos por post.'
            );
        }
        return response()->json($signup,200);
    }

}
