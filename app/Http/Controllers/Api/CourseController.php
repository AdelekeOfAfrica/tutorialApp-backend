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
}
