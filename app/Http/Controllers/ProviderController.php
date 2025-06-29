<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
