<?php

namespace App\Admin\Controllers;

use App\Model\PGoodsModel;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Model\PAttrModel;
use App\Model\PcateModel;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Layout\Content;
use App\Admin\Actions\Post\Replicate;
use Illuminate\Support\Facades\Redis;
class GoodsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品展示';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PGoodsModel);

        $grid->column('goods_id', __('id'));
        $grid->column('goods_sn', __('商品号'));
        $grid->column('goods_name', __('商品名称'));
        $grid->column('cat_id', __('分类ID'));
        $grid->column('attr', __('属性'));
        $grid->column('goods_img', __('商品图片'))->image();
        $grid->column('short_desc', __('描述'));
        $grid->column('price0', __('定价'));
        $grid->column('price', __('售价'));
        $grid->column('created_at', __('添加时间'));
        $grid->column('updated_at', __('修改时间'));
        $grid->column('is_delete', __('Is delete'));
        $grid->column('is_onsale', __('Is onsale'));
        $grid->actions(function($actions){
            $actions->add(new Replicate);
        });
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
        $show = new Show(PGoodsModel::findOrFail($id));

        $show->field('goods_id', __('Goods id'));
        $show->field('goods_sn', __('Goods sn'));
        $show->field('goods_name', __('Goods name'));
        $show->field('cat_id', __('Cat id'));
        $show->field('attr', __('Attr'));
        $show->field('goods_img', __('Goods img'));
        $show->field('short_desc', __('Short desc'));
        $show->field('price0', __('Price0'));
        $show->field('price', __('Price'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('is_delete', __('Is delete'));
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
        $form = new Form(new PGoodsModel);

        $form->text('goods_sn', __('订单号'));
        $form->text('goods_name', __('Goods name'));
        $form->select('cat_id', __('分类'))->options(PcateModel::selectOptions());
        //属性
        $form->select('attr1', '属性1')->options(PAttrModel::selectOptions());
        $form->select('attr2', '属性2')->options(PAttrModel::selectOptions());
        $form->file('goods_img', __('Goods img'));
        $form->text('short_desc', __('Short desc'));
        $form->number('price0', __('Price0'));
        $form->number('price', __('Price'));
        $form->switch('is_delete', __('Is delete'));
        $form->switch('is_onsale', __('Is onsale'))->default(1);

        return $form;
    }

    //添加
    public function store()
    {
        echo '<pre>';print_r($_POST);echo '</pre>';
        $attr1 = $_POST['attr1'];
        $attr2 = $_POST['attr2'];
        unset($_POST['attr1']);
        unset($_POST['attr2']);
        unset($_POST['_token']);
        unset($_POST['_previous_']);
        if($_POST['is_delete']=='on'){
            $_POST['is_delete'] = 1;
        }else{
            $_POST['is_delete'] = 0;
        }

        if($_POST['is_onsale']=='on'){
            $_POST['is_onsale'] = 1;
        }else{
            $_POST['is_onsale'] = 0;
        }
        $_POST['attr'] = $attr1 . ',' . $attr2;
        PGoodsModel::insert($_POST);
    }
}
