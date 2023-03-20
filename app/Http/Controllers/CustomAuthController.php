<?php

namespace App\Http\Controllers;

use App\Models\User;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;

class CustomAuthController extends Controller
{
    public function login(){
        return view('Auth.login');
    }

    public function register(){
        return view('Auth.register');
    }

    //register user
    public function registerUser(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password'  => 'required|max:12|min:5'
        ]);
        $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        $result = $users->save();
        return back()->with('success','You have registered Successfully');
    }

    //login user
    public function loginUser(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password'  => 'required|max:12|min:5'
        ]);

        $user = User::where('email','=',$request->email)->first();
        if($user){
            if(Hash::check($request->password,$user->password)){
                $request->session()->put('loginId', $user->id);
                return redirect('dashboard');
            }else{
                return back()->with('fail', "Password doesn't matches.");
            }
        }else{
            return back()->with('fail', 'This email is not registered.');
        }
    }

    // Dashboard
    public function dashboard(){
        $data = array();
        if (Session::has('loginId')){
            $data = User::where('id','=', Session::get('loginId'))->first();
        }
        return view('dashboard',compact('data'));
    }

    // Logout 
    public function logout(){
        if(Session::has('loginId')){
            Session::pull('loginId');

            return redirect('login');
        }
    }
}
