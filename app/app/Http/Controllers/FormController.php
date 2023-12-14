<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Password;


class FormController extends Controller
{
   
    function getForm(Request $request){
    
        //verification des input
        $validator = Validator::make($request->all(), [
            'url' => 'required|string|url',

            'login' => 'required|string',


            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            $errors = $validator->messages();

            $fields = ['url', 'login', 'password'];

        
            foreach ($fields as $field) {
                if ($errors->has($field)) {
                    Session::flash($field . '_error', $errors->first($field));
                }
            }
        
        
            return redirect()->back()->withInput();
        }else{

            


            $url = $request->input('url');
            $login = $request->input('login');
            $password = $request->input('password');
            //___________________________________
            //_______INSERTION BDD PASSWORD______
            //___________________________________
            $passwordModel= new Password();
            $passwordModel->site = $url;
            $passwordModel->login = $login;
            $passwordModel->password = $password;
            $passwordModel->user_id = auth()->user()->id;
            $passwordModel->save();
            //________________________________
           
            $data = [
                "url" => $url,
                "login" => $login,
                "password"=> $password
            ];
            
            $files = Storage::disk('local_json')->files();
            $filecount = count($files);

            $num = strval($filecount);

            $filename = "password_$num.json"; 

            Storage::disk('local_json')->put($filename, json_encode($data));

            return redirect('/page-verif'); 
        }
    }
}