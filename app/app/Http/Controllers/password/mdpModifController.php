<?php

namespace App\Http\Controllers\password;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Password;
use App\Models\User;


class mdpModifController extends Controller
{
    function modifMdp(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'new_password' => 'required|string',
           
        ]);
        if ($validator->fails()) {
            $errors = $validator->messages();

            $field = 'new_password';
            if ($errors->has($field)) 
            {
               Session::flash($field . '_error',$errors->first($field));   
            }
          
            return redirect()->back()->withInput();
            
           
        }else{
            $info = Password::findOrFail($id);
            $info->password = $request->input('new_password');
            $info->save();
            //return view('liste');
            return redirect()->route('liste');
        }

       
    }

    
    function formModifMdp($id){
        $info = Password::findOrFail($id); 
        Log::info('Debug message:', ['info' => $info]);
        return view('modif-mdp',['info'=>$info]);
    }
   
   
}

