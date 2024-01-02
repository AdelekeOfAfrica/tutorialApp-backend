<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    //

    public function CourseList(){
        //select method is better cause it allows you to select the fields 
        $result =Course::select('name','thumbnail','lesson_num','price','id')->get();
        return response()->json([
            'code' =>200,
            "msg"=>"Course fetch successfully",
            "data"=>$result
        ],200);
    }

    public function CourseDetail(Request $request){
        $id = $request->id;

    try{
       $result = Course::where('id', '=', $id)->select('id','name','user_token','description','thumbnail','lesson_num','price','video_length')->first();

       return response()->json([
        'code'=>200,
        'message'=>'CourseDetail fetched Successfully',
        'data'=>$result
       ],200);
    }catch(\Throwable $e){
        return response()->json([
            'code'=>500,
            'message'=>'There was an error fetching the course Details',
            'data'=>$e->getMessage(),
           ],500);
    }

    }
}
