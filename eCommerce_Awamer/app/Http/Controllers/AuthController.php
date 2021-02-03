<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;

class AuthController extends Controller
{
    public function inputFilter($input_field){
        $input = htmlspecialchars(stripcslashes(strip_tags($input_field)));
        return $input;
    }

    public function login(){
        if(session()->has('seller') || session()->has('customer')){
            return redirect('/');
        }else{
            return view('login');
        }
    }

    public function loginPost(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $login = DB::table('users')->where([
            'email' => $request->email,
        ])->first();

        if($login && Hash::check($request->password,$login->password)){
            if($login->email_verified_at !== null){
                if($login->role == 'seller'){
                    $request->session()->put('seller',$login);
                    return redirect('/');
                }else{
                    $request->session()->put('customer',$login);
                    return redirect('/');
                } 
            }else{
                return redirect('/login')->with('note_for_email','this email is not verified please check your box');
            }
        }else{
            return redirect('/login')->with('note_for_email','email and password is not matched');
        }

    }

    public function register(){
        return view('register');
    }

    public function registerPost(Request $request){
        $request->validate([
            'username' => 'required|string|min:6',
            'personal_mobile' => 'required|string|min:6',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'repeat_password' => 'required_with:password|same:password|min:8',
            'role' => 'required|string'
        ]);
        $ifEmailExist = DB::table('users')->Where([
            'email' => $request->email,
        ])->first();
        if($ifEmailExist){
            return back()->with('email_exist','This Email ' . $request->email . ' is ready exist');
        }else{

            //insert new user
            $register = DB::table('users')->insertGetId([
                'username' => $this->inputFilter($request->username),
                'personal_mobile' => $this->inputFilter($request->personal_mobile),
                'email' => $this->inputFilter($request->email),
                'password' => Hash::make($request->password),
                'role' => $this->inputFilter($request->role),
                'created_at' => now(),
            ]);
    
    
            if($register){
                // create random for verify email
                $random_verify_email = DB::table('verify')->insertGetId([
                    'user_id' => $register,
                    'random' => time(),
                    'date' => date('Y-m-d'),
                ]);
                
                if($random_verify_email){
                    // Send Link For Verify Email
                    $selectRandom = DB::table('verify')->where([
                        'id' => $random_verify_email,
                    ])->first();

                    $details = [
                        'title' => 'From E-Commerce_Awamer To Verify Email',
                        'body'  => $_SERVER['HTTP_HOST'].'/verify?user_id=' . $register .'&email='. $request->email . '&random_code=' . $selectRandom->random,
                    ];

                    Mail::to($request->email)->send(new VerifyEmail($details));
                    echo "<script>setTimeout(function(){ window.location.href = '/login'; }, 3000);</script>";
                    return back()->with('success','The account has been registered. Check mail for activation');
                }
    
            }
        } 

    }

    //for verify and update email and return message success
    public function verifyEmail(Request $request){
        $user = DB::table('users')->where([
            'id' => intval($request->user_id),
            'email' => $request->email,
            'email_verified_at' => null,
        ])->first();

        if($user){

            $check_random_success = DB::table('verify')->where([
                'user_id' => intval($request->user_id),
                'random'  => $request->random_code,
                'date'    => date('Y-m-d')
            ])->orderBy('id','desc')->first();
            
            if($check_random_success){
                
                $verifyEmail = DB::table('users')->where([
                    'email' => $this->inputFilter($request->email),
                    'id' => intval($request->user_id)
                ])->update([
                    'email_verified_at' => date('Y-m-d')
                ]);

                if($verifyEmail){
                    $message = 'this email ' . $this->inputFilter($request->email) . ' is verified successfully';
                    echo "<script>setTimeout(function(){ window.location.href = '/login'; }, 3000);</script>";
                    return view('notifications',compact('message'));
                }

            }else{
                $message = 'this link is expired';
                echo "<script>setTimeout(function(){ window.location.href = '/login'; }, 3000);</script>";
                return view('notifications',compact('message'));
            }

            
        }else{
            return redirect('/login');
        }
    }
    public function logout(){

        if(session()->has('seller')){

            session()->forget('seller');
            return redirect('/login');

        }elseif(session()->has('customer')){

            session()->forget('customer');
            return redirect('/login');

        }else{
            return redirect('/login');
        }
    }

}





