<?php

namespace App\Admin\Controllers;

use App\Model\PAttrValueModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Model\PAttrModel;
class AttrValueController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '属性值添加';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PAttrValueModel);

        $grid->column('id', __('Id'));
        $grid->column('attr_id', __('属性ID'));
        $grid->column('title', __('Title'));
        $grid->column('order', __('Order'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(PAttrValueModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('attr_id', __('Attr id'));
        $show->field('title', __('Title'));
        $show->field('order', __('Order'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PAttrValueModel);
//        $form->number('attr_id', __('Order'))->default(1);
        $form->select('attr_id', __('属性名'))->options(PAttrModel::selectOptions());
        $form->text('title', __('Title'));
        $form->number('order', __('Order'))->default(1);

        return $form;
    }
}
