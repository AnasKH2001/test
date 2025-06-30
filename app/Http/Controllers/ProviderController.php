<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;


class ProviderController extends Controller
{
    


   
     
      public function providerLogout(Request $request){

$request->user()->currentAccessToken()->delete();
return response()->json([
            
  'message'=>' provider logout Successfully',
 
  
  ] 
           );

           
     
        }
      
      



}