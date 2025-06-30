<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Provider;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{


  
    public function register(Request $request)
    {
       $request->validate([

          'name'=>'required|string|max:255',
          'role'=>'required|string|max:255',
          'email'=>'required|unique:users,email|email',
          'password'=>'required|string|min:5' ,

       ]);



         $user= User ::create([

            'name'=>$request->name,
            'role'=>$request->role, 
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
             
          ]);
          if ($user->role === 'provider') {
              Provider::create(['user_id' => $user->id]);
          } elseif ($user->role === 'customer') {
              Customer::create(['user_id' => $user->id]);
          }

          return response()->json([
            
            'message'=>'User Registered Successfully',
            
            'User'=> $user] 
            ,201
            
            
          );

    }

  



    public function login(Request $request)
    {
        $request->validate([
            
            'email'=>'required',
            'password'=>'required|string'
            
                   ]);

            if(! Auth::attempt($request->only('email','password')))
    
            return response()->json(
  [

    'message'=>'invilid email or password' ]

      ,401);


   $user= User::where('email',$request->email)->FirstOrFail();
   $token=$user->createToken('auth_Token')->plainTextToken;



    return response()->json([
            
    'message'=>'login Successfully',
   
    'User'=> $user,
    'Token'=>$token
    ] 
    , 201            );

    }


    public function logout(Request $request){

$request->user()->currentAccessToken()->delete();
return response()->json([
            
  'message'=>'logout Successfully',
 
  
  ] 
           );
     
        }
      
      



      }