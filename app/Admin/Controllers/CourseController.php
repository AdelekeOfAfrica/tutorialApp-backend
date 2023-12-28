<?php

namespace App\Admin\Controllers;

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

   public function index(Content $content){ //this is more like request in laravel 
    $tree = new Tree(new CourseType); // this will show the result in menu and submenu format 
    return $content->header("Course Types")->body($tree);

}
  

     protected function form(){ // this is creating the form section

        $form = new Form(new Course());
        $form->select('parent_id',_('Parent_Category'))->options((new Course())::selectOptions());
        $form ->text('title',_("Title"));
        $form->textarea('description',_('Description'));
        $form->number("order", _("Order"));

        return $form;


     }
}

