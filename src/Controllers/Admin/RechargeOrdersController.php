<?php

namespace Qihucms\Currency\Controllers\Admin;

use App\Admin\Controllers\Controller;
use App\Models\User;
use Qihucms\Currency\Models\CurrencyRechargeOrder;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Qihucms\Currency\Models\CurrencyType;

class RechargeOrdersController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '充值记录';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CurrencyRechargeOrder);

        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->equal('user_id', __('currency::recharge_order.user_id'));
            $filter->equal('currency_type_id', __('currency::recharge_order.currency_type_id'))
                ->select(CurrencyType::all()->pluck('name', 'id'));
            $filter->between('rate', __('currency::recharge_order.rate'));
            $filter->between('recharge_amount', __('currency::recharge_order.recharge_amount'));
            $filter->between('recorded_amount', __('currency::recharge_order.recorded_amount'));
        });

        $grid->column('id', __('currency::recharge_order.id'));
        $grid->column('user.username', __('user.username'));
        $grid->column('currency_type.name', __('currency::type.name'));
        $grid->column('rate', __('currency::recharge_order.rate'));
        $grid->column('recharge_amount', __('currency::recharge_order.recharge_amount'));
        $grid->column('recorded_amount', __('currency::recharge_order.recorded_amount'));
        $grid->column('user_amount', __('currency::recharge_order.user_amount'));
        $grid->column('status', __('currency::recharge_order.status.label'))
            ->using(__('currency::recharge_order.status.value'));

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
        $show = new Show(CurrencyRechargeOrder::findOrFail($id));

        $show->field('id', __('currency::recharge_order.id'));
        $show->field('user_id', __('currency::recharge_order.user_id'))
            ->as(function () {
                return $this->user->nickname ?? trans('currency::message.record_does_not_exist');
            });
        $show->field('currency_type_id', __('currency::recharge_order.currency_type_id'))
            ->as(function () {
                return $this->currency_type->name ?? trans('currency::message.record_does_not_exist');
            });
        $show->field('rate', __('currency::recharge_order.rate'));
        $show->field('recharge_amount', __('currency::recharge_order.recharge_amount'));
        $show->field('recorded_amount', __('currency::recharge_order.recorded_amount'));
        $show->field('user_amount', __('currency::recharge_order.user_amount'));
        $show->field('status', __('currency::recharge_order.status.label'))
            ->using(__('currency::recharge_order.status.value'));
        $show->field('created_at', __('admin.created_at'));
        $show->field('updated_at', __('admin.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CurrencyRechargeOrder);

        $form->select('user_id', __('currency::recharge_order.user_id'))
            ->options(function ($id) {
                $user = User::find($id);
                if ($user) {
                    return [$user->id => $user->username];
                }
            })
            ->ajax(route('admin.user.select'))
            ->required();
        $form->select('currency_type_id', __('currency::recharge_order.currency_type_id'))
            ->options(CurrencyType::all()->pluck('name', 'id'))
            ->required();
        $form->rate('rate', __('currency::recharge_order.rate'))->default(100)->required();
        $form->currency('recharge_amount', __('currency::recharge_order.recharge_amount'))
            ->symbol(config('qihu.currency_symbol', '¥'))->required();
        $form->currency('recorded_amount', __('currency::recharge_order.recorded_amount'))
            ->symbol(config('qihu.currency_symbol', '¥'))->required();
        $form->currency('user_amount', __('currency::recharge_order.user_amount'))
            ->symbol(config('qihu.currency_symbol', '¥'))->required();
        $form->select('status', __('currency::recharge_order.status.label'))
            ->options(__('currency::recharge_order.status.value'));

        return $form;
    }
}