<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\Course;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Tree;
use App\Models\CourseType;
use Illuminate\Http\Request;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\AdminController;



class CourseController extends AdminController
{
    //
    protected $title ="Course";

    protected function grid(){
        $grid = new Grid(new Course()); // this is to return all the information on the table// more or index get::all
        $grid->column('id',_('Id'));
        $grid->column('user_token',_('Teacher'))->display(function($token){
            // for further processing of any data, you can  create any method iniside it or do operation
             return User::where('token', '=', $token)->value('name'); // go into the user table and fetch the name of the user that has the $token value 
        });
        $grid->column('name',_('Name'));
        $grid->column('thumbnail',_('Thumbnail'))->image('',50,50); //50 50 reference to the image size
        $grid->column('description',_('Description'));
        $grid->column('type_id',_('Type_id'));
        $grid->column('price',_('Price'));
        $grid->column('lesson_num',_('Lesson num'));
        $grid->column('video_length',_('Video Length'));
        $grid->column('created_at',_('Created At'));
 
        return $grid;
    }


    protected function detail($id) // this function is to find exact course record
    {
        $show = new Show(Course::findOrFail($id));

    $show->field('name',_('Name'));
    $show->field('thumbnail',_('Thumbnail'));//50 50 reference to the image size
    $show->field('description',_('Description'));
    $show->field('price',_('Price'));
    $show->field('follow',_('Follow'));
    $show->field('score',_('Score'));
    $show->field('lesson_num',_('Lesson num'));
    $show->field('video_length',_('Video Length'));
    $show->field('created_at',_('Created At'));
    $show->field('updated_at',_('Updated At'));

    return $show;
     }

     protected function form(){ // this is creating the form section

        $form = new Form(new Course());
       
        $form ->text('name',_("Name"));
        //get our categories 
        $result=CourseType::pluck('title','id'); // fetch all coursetypes available more or less like the category
        $form->select('type_id',_('Category'))->options($result);
        $form->image('thumbnail',__('Thumbnail'))->uniqueName();
        //file is used for video and other format like pdf
        $form->file('video',_('Video'))->uniqueName();
        $form->text('description',_('Description'));
        //decimal method helps with price 
        $form->decimal('price',_('Price'));
        $form->number('lesson_num',_('Lesson number'));
        $form->number('video_length',__('Video Length'));

        $result = User::pluck('name','token');//this is used to fetch the available users 
        $form->select('user_token',_('Teacher'))->options($result);
        $form->display('created_at',_('Created at'));      
         $form->display('updated_at',_('Updated at')); 

        return $form;


     }
}

