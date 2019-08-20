<?php

namespace App\Admin\Controllers;

use App\Model\PcateModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CateValueController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '分类管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PcateModel);

        $grid->column('cid', __('Cid'));
        $grid->column('title', __('分类名'));
        $grid->column('parent_id', __('父级分类ID'));
        $grid->column('order', __('排序'));
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
        $show = new Show(PcateModel::findOrFail($id));

        $show->field('cid', __('Cid'));
        $show->field('title', __('Title'));
        $show->field('parent_id', __('Parent id'));
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
        $form = new Form(new PcateModel);

        $form->text('title', __('Title'));
        $form->select('parent_id', '父级分类')->options(PcateModel::selectOptions());
        $form->number('order', __('Order'));

        return $form;
    }
}
