<?php

namespace Qihucms\Currency\Controllers\Admin;

use App\Admin\Controllers\Controller;
use Qihucms\Currency\Models\CurrencyType;
use Qihucms\Currency\Models\CurrencyExchange;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ExchangesController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '兑换设置';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CurrencyExchange);

        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->equal('currency_type_id', __('currency::exchange.currency_type_id'))
                ->select(CurrencyType::all()->pluck('name', 'id'));
            $filter->equal('currency_type_to_id', __('currency::exchange.currency_type_to_id'))
                ->select(CurrencyType::all()->pluck('name', 'id'));
            $filter->between('rate', __('currency::exchange.rate'));
            $filter->between('exchange_max_amount', __('currency::exchange.exchange_max_amount'));
        });

        $grid->column('id', __('currency::exchange.id'));
        $grid->column('currency_type.name', __('currency::exchange.currency_type_id'));
        $grid->column('currency_type_to.name', __('currency::exchange.currency_type_to_id'));
        $grid->column('rate', __('currency::exchange.rate'))->prefix('10000:');
        $grid->column('exchange_max_amount', __('currency::exchange.exchange_max_amount'));

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
        $show = new Show(CurrencyExchange::findOrFail($id));

        $show->field('id', __('currency::exchange.id'));
        $show->field('currency_type_id', __('currency::exchange.currency_type_id'))->as(function () {
            return $this->currency_type->name ?? trans('currency::message.record_does_not_exist');
        });
        $show->field('currency_type_to_id', __('currency::exchange.currency_type_to_id'))->as(function () {
            return $this->currency_type_to->name ?? trans('currency::message.record_does_not_exist');
        });
        $show->field('rate', __('currency::exchange.rate'));
        $show->field('exchange_max_amount', __('currency::exchange.exchange_max_amount'));
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
        $form = new Form(new CurrencyExchange);
        
        $form->select('currency_type_id', __('currency::exchange.currency_type_id'))
            ->options(CurrencyType::all()->pluck('name', 'id'))
            ->help(__('currency::exchange.currency_type_id_help'))
            ->required();
        $form->select('currency_type_to_id', __('currency::exchange.currency_type_to_id'))
            ->options(CurrencyType::all()->pluck('name', 'id'))
            ->help(__('currency::exchange.currency_type_to_id_help'))
            ->required();
        $form->number('rate', __('currency::exchange.rate'))
            ->default(1)
            ->help(__('currency::exchange.rate_help'))
            ->required();
        $form->currency('exchange_max_amount', __('currency::exchange.exchange_max_amount'))
            ->help(__('currency::exchange.exchange_max_amount_help'))
            ->symbol('*')->required();

        return $form;
    }
}
