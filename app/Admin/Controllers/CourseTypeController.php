<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Tree;
use App\Models\CourseType;
use Illuminate\Http\Request;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\AdminController;

class CourseTypeController extends AdminController
{
    //

    protected $title="Course Type";

   public function index(Content $content){ //this is more like request in laravel 
    $tree = new Tree(new CourseType); // this will show the result in menu and submenu format 
    return $content->header("Course Types")->body($tree);

}
    protected function detail($id) // this function is to find exact course record
    {
        $show = new Show(CourseType::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Category'));
        $show->field('description', __('Description'));
        $show->field("order",__("Order"));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        // $show->disableActions(); // this is will lock all the functions of adding, editing and deleting the data on the table 
    //     $show->disableCreateButton(); // this will disable create button
    //     $show->disableFilter();
    //     $show->disableExport();
    //     return $show;
     }

     protected function form(){ // this is creating the form section

        $form = new Form(new CourseType());
        $form->select('parent_id',_('Parent_Category'))->options((new CourseType())::selectOptions());
        $form ->text('title',_("Title"));
        $form->textarea('description',_('Description'));
        $form->number("order", _("Order"));

        return $form;


     }
}
