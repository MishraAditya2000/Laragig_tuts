<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PDO;

class UserController extends Controller
{
    //SHOW REGISTER FORM
     public function create(){
        return view('users.register');
    }

    //STORE NEW USER
    public function store(Request $request){
        // dd($request);
        $formFields=$request->validate([
            'name'=>['required','min:3'],
            'email'=>['required',Rule::unique('users','email')],
            'password'=>'required|confirmed|min:6'
            ]
        );
        //HASH PASSWORD
        $formFields['password']=bcrypt($formFields['password']);
        $user=User::create($formFields);

        auth()->login($user);

        return redirect('/')->with('message','Register Successfully,Welcome');

    }

    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','Logout Successfully');

    }

    public function login(){
        return view('users.login');
    } 

    public function authenticate(Request $request){
        $formFields=$request->validate([
            'email'=>['required','email'],
            'password'=>'required'
            ]
        );

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect('/')->with('message','Login Successfully');
        }
        else{
            return back()->withErrors(['email'=>'Invalid Credentials'])->onlyInput('email');
        }
    }
}
