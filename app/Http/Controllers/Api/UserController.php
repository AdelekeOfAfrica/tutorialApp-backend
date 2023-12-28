<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //


    //this createUser is also used for loggin users in also 
    public function login(Request $request) {

        // return response()->json([
        //     "code"=>200,
        //     "msg"=>"user loggedin Successfully",
        //     "token"=>"some random token"
        // ]);

        try{
        $validator = Validator::make($request->all(),[
            "avatar"=>"required",
            "type" =>"required",
            "open_id"=>"required",
           "name"=> "required",
           "email"=>"required",
        //    "password"=>"required|min:6"
           
        ]);

        if($validator->fails()){
            return response()->json([
                "status"=>false,
                "message"=>"validation error",
                "errors"=>$validator->errors()
            ],401);
        }

        $validated =$validator->validated();
        $map =[];
        $map ["type"] =$validated["type"];
        $map["open_id"] = $validated["open_id"]; // connecting with google 

        $user = User::where($map)->first();
        if(empty($user->id)){
            $validated ["token"]=md5(uniqid().rand(10000,9999));
            $validated["created_at"] = Carbon::now();
            $userID = User::InsertGetId($validated);
            $userInfo = User::where('id',"=",$userID)->first();
            $accessToken = $userInfo->createToken(uniqid())->plainTextToken;
            $userInfo->access_token = $accessToken;
            User::where('id', '=',$userID)->update(["access_token"=>$accessToken]);

            return response()->json([
                "code"=>200,
                "msg"=>"user created Successfully",
                "data"=>$userInfo
            ],200);

          


        }
        //user has previously logged in 
        $accessToken = $user->createToken(uniqid())->plainTextToken;
        $user->access_token = $accessToken;
        User::where("open_id", "=",$validated["open_id"])->update(["access_token"=>$accessToken]);
        return response()->json([
            "code"=>200,
            "msg"=>"user loggedin Successfully",
            "data"=>$user
        ],200);
        


      

    }
    catch(\Throwable $th){
        return response()->json(["status"=>false,
        "message"=>$th->getMessage()],500);

    }


    }
// <!-- 
//     public function loginUser(Request $request) {
//         try{
//             $validator = Validator::make($request->all(),[
//                 "email"=>"required|email",
//                 "password"=>"required"
//             ]);

//             if($validator->fails()){
//                 return response()->json([
//                     "status"=>false,
//                     "message"=>"validation failed",
//                     "error"=>$validator->errors()
//                 ],401);

            
//             } if(!Auth::attempt($request->only(["email","password"]))){
//                 return response()->json([
//                     "status"=>false,
//                     "message"=>"Email & Password does not match any of our record",    
//                 ],401);
//             }

//             $user = User::where('email', $request->email)->first();
//             return response()->json([
//                 "status"=>true,
//                 "message"=>"user logged in successfully",
//                 "token"=>$user->createToken("Api Token")->plainTextToken
//             ],200);
//         }catch(\Throwable $th){
//             return response()->json([
//                 "status"=>false,
//                 "message"=>$th->getMessage()
//             ],500);
//         }
//     } -->
}
