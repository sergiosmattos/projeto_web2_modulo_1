<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    public function login(){
        return view('login');
    }

    public function loginSubmit(Request $request){
        $request->validate(
            [
                'text_email' => 'required|min:10|email',
                'text_password' => 'required|min:6',
            ],
            [
                'text_email.required' => 'O campo e-mail é obrigatório.',
                'text_email.email' => 'O campo de e-mail deve conter um endereço válido.',
                'text_emain.min' => 'O campo e-mail deve ter no mínimo 10 caracteres',

                'text_password.required' => 'O campo senha é obrigatório.',
                'text_password.min' => 'O campo senha deve ter no mínimo 6 caracteres',

            ]
        );
        
        $email = $request->input('text_email');
        $password = $request->input('text_password');

        $user = User::where('email',$email)
                    ->first();

        if(!$user){
            return redirect()->back()
                    ->withInput()
                    ->with('login_error','Email ou senha incorretos!');
        } else {
            if(!password_verify($password,$user->password)){
                return redirect()->back()
                        ->withInput()
                        ->with('login_error','Email ou senha incorretos!');
            }
        }
        
       
            session([
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'permission' => $user->permission,
            ]
        ]);

        return redirect('/');

    }

    public function create(){
        return view('cadastro-usuario');
    }

     public function createSubmit(Request $request){
        $request->validate([
            'text_email' => 'required|min:6|max:200|email',
            'text_name' => 'required|min:3|max:3000',
            'text_password' => 'required|min:6',
        ], [
            'text_email.required' => 'O e-mail é obrigatório.',
            'text_email.min' => 'O email deve ter pelo menos :min caracteres.',
            'text_email.email' => 'O campo de e-mail deve conter um endereço válido.',
            'text_name.required' => 'O Nome e sobrenome deve ter no máximo :max caracteres.',
            'text_name.min' => 'O nome e sobremone é obrigatória.',
            'text_password.required' => 'A senha é obrigatória',
            'text_password.min' => 'A senha deve ter no minímo :min caracteres.',
        ]);

        $user = new User();
        $user->email = $request->text_email;
        $user->name = $request->text_name;
        $user->password = bcrypt($request->text_password);
        $user->permission = 'user';
        $user->save();

        session([
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'permission' => $user->permission,
            ]
        ]);

        return redirect()->route('home_page');
    
    }

    public function logout(){

        session()->forget('user');

       return redirect()->route('login');
    }

}
