<?php

namespace App\Admin\Controllers;

use App\Model\PSkuModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SkuController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'SKU管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PSkuModel);

        $grid->column('id', __('Id'));
        $grid->column('goods_id', __('Goods id'));
        $grid->column('goods_sn', __('Goods sn'));
        $grid->column('sku', __('Sku'));
        $grid->column('attr_path', __('Attr path'));
        $grid->column('desc', __('Desc'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('price0', __('Price0'));
        $grid->column('price', __('Price'));
        $grid->column('store', __('Store'));
        $grid->column('is_onsale', __('Is onsale'));

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
        $show = new Show(PSkuModel::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('goods_id', __('Goods id'));
        $show->field('goods_sn', __('Goods sn'));
        $show->field('sku', __('Sku'));
        $show->field('attr_path', __('Attr path'));
        $show->field('desc', __('Desc'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('price0', __('Price0'));
        $show->field('price', __('Price'));
        $show->field('store', __('Store'));
        $show->field('is_onsale', __('Is onsale'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PSkuModel);

        $form->text('goods_id', __('Goods id'));
        $form->text('goods_sn', __('Goods sn'));
        $form->text('sku', __('Sku'));
        $form->text('desc', __('Desc'));
        $form->number('price0', __('Price0'));
        $form->number('price', __('Price'));
        $form->number('store', __('Store'));
        return $form;
    }

    public function skuDetail(Content $content,$id){

    }
    public function skuUpdate()
    {
        $attr_path = '';
        for($i=0;$i<3;$i++)
        {
            if(isset($_POST['attr'.$i])){
                $attr_path .= $_POST['attr'.$i] . ',';
                unset($_POST['attr'.$i]);
            }
        }

        $_POST['attr_path'] = rtrim($attr_path,',');
        unset($_POST['_token']);
        //echo '<pre>';print_r($_POST);echo '</pre>';
        PSkuModel::insert($_POST);
        admin_toastr('添加成功','success');
        return redirect('/admin/sku-detail/'.$_POST['goods_id']);
    }

}
