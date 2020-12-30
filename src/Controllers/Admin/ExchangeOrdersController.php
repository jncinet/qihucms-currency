<?php

namespace Qihucms\Currency\Controllers\Admin;

use App\Admin\Controllers\Controller;
use App\Models\User;
use Qihucms\Currency\Models\CurrencyExchange;
use Qihucms\Currency\Models\CurrencyExchangeOrder;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ExchangeOrdersController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '兑换记录';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CurrencyExchangeOrder);

        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->equal('user_id', __('currency::exchange_order.user_id'));
            $filter->equal('currency_exchange_id', __('currency::exchange_order.currency_exchange_id'))
                ->select(CurrencyExchange::all()->pluck('id', 'id'));
            $filter->between('rate', __('currency::exchange_order.rate'));
            $filter->between('exchange_amount', __('currency::exchange_order.exchange_amount'));
            $filter->between('recorded_amount', __('currency::exchange_order.recorded_amount'));
        });

        $grid->column('id', __('currency::exchange_order.id'));
        $grid->column('user.username', __('user.username'));
        $grid->column('currency_exchange_id', __('currency::exchange_order.currency_exchange_id'))
            ->display(function () {
                return $this->currency_exchange->currency_type->name . ' => ' . $this->currency_exchange->currency_type_to->name;
            });
        $grid->column('rate', __('currency::exchange_order.rate'));
        $grid->column('exchange_amount', __('currency::exchange_order.exchange_amount'));
        $grid->column('recorded_amount', __('currency::exchange_order.recorded_amount'));
        $grid->column('user_amount', __('currency::exchange_order.user_amount'));
        $grid->column('status', __('currency::exchange_order.status.label'))
            ->using(__('currency::exchange_order.status.value'));

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
        $show = new Show(CurrencyExchangeOrder::findOrFail($id));

        $show->field('id', __('currency::exchange_order.id'));
        $show->field('user_id', __('currency::exchange_order.user_id'))
            ->as(function () {
                return $this->user->nickname ?? trans('currency::message.record_does_not_exist');
            });
        $show->field('currency_exchange', __('currency::exchange_order.currency_exchange_id'))
            ->as(function () {
                return $this->currency_exchange->currency_type->name . ' => ' . $this->currency_exchange->currency_type_to->name ?? '类型不存在';
            });
        $show->field('rate', __('currency::exchange_order.rate'));
        $show->field('exchange_amount', __('currency::exchange_order.exchange_amount'));
        $show->field('recorded_amount', __('currency::exchange_order.recorded_amount'));
        $show->field('user_amount', __('currency::exchange_order.user_amount'));
        $show->field('status', __('currency::exchange_order.status.label'))
            ->using(__('currency::exchange_order.status.value'));
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
        $form = new Form(new CurrencyExchangeOrder);

        $form->select('user_id', __('currency::exchange_order.user_id'))
            ->options(function ($id) {
                $user = User::find($id);
                if ($user) {
                    return [$user->id => $user->username];
                }
            })
            ->ajax(route('admin.select.user'))
            ->required();
        $form->select('currency_exchange_id', __('currency::exchange_order.currency_exchange_id'))
            ->options(CurrencyExchange::all()->pluck('id', 'id'))
            ->required();
        $form->rate('rate', __('currency::exchange_order.rate'))->default(100)->required();
        $form->currency('exchange_amount', __('currency::exchange_order.exchange_amount'))
            ->symbol('*')->required();
        $form->currency('recorded_amount', __('currency::exchange_order.recorded_amount'))
            ->symbol('*')->required();
        $form->currency('user_amount', __('currency::exchange_order.user_amount'))
            ->symbol('*')->required();
        $form->select('status', __('currency::exchange_order.status.label'))
            ->options(__('currency::exchange_order.status.value'));

        return $form;
    }
}
