<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;

    protected $cast=[
        'video'=>'json'
    ];

    public function setVideoAttribute($value){
        $this->attributes['video'] = json_encode(array_values($value));

    }

    public function getVideoAttribute($value){
        $result_video = json_decode($value, true)?:[];

        if (!empty($result_video)){
            foreach($result_video as $k=>$v){
                $result_video[$k]["url"]=$v["url"];
                $result_video[$k]["thumbnail"]=$v["thumbnail"];
            }
        }
       return $result_video;
    }
}
