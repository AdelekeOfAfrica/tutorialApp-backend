<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LessonController extends Controller
{
    //

    public function lessonList(Request $request){
        $id = $request->id;

        try{
           $result = Lesson::where('course_id', '=', $id)->select('id','name','description','thumbnail','video')->get();
    
           return response()->json([
            'code'=>200,
            'message'=>'Available lesson list for the course',
            'data'=>$result
           ],200);
        }catch(\Throwable $e){
            return response()->json([
                'code'=>500,
                'message'=>'There was an error fetching the Lesson List',
                'data'=>$e->getMessage(),
               ],500);
        }

    }

    public function lessonDetail(Request $request){
        $id = $request->id;

        try{
           $result = Lesson::where('id', '=', $id)->select('name','description','thumbnail','video')->get();
    
           return response()->json([
            'code'=>200,
            'message'=>'Lesson details is here ',
            'data'=>$result
           ],200);
        }catch(\Throwable $e){
            return response()->json([
                'code'=>500,
                'message'=>'There was an error fetching the Lesson Details',
                'data'=>$e->getMessage(),
               ],500);
        }

    }
}
