<?php

namespace Qihucms\Currency\Controllers\Admin;

use App\Admin\Controllers\Controller;
use Qihucms\Currency\Models\CurrencyType;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TypesController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '货币管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CurrencyType);

        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->equal('name', __('currency::type.name'));
            $filter->equal('recharge_rate', __('currency::type.recharge_rate'));
            $filter->equal('recharge_status', __('currency::type.recharge_status.label'))
                ->select(__('currency::type.recharge_status.value'));
            $filter->equal('exchange_status', __('currency::type.exchange_status.label'))
                ->select(__('currency::type.exchange_status.value'));
            $filter->equal('cash_out_status', __('currency::type.cash_out_status.label'))
                ->select(__('currency::type.cash_out_status.value'));
        });

        $grid->column('id', __('currency::type.id'));
        $grid->column('ico', __('currency::type.ico'))->image('', 32);
        $grid->column('name', __('currency::type.name'));
        $grid->column('unit', __('currency::type.unit'));
        $grid->column('recharge_rate', __('currency::type.recharge_rate'))
            ->display(function ($recharge_rate) {
                if ($recharge_rate > 0) {
                    return __('currency::recharge_rate_tip', ['rate' => $recharge_rate]);
                } else {
                    return __('currency::type.not_recharge');
                }
            });
        $grid->column('cash_out_rate', __('currency::type.cash_out_rate'))
            ->display(function ($cash_out_rate) {
                if ($cash_out_rate > 0) {
                    return __('currency::type.cash_out_rate_tip', ['rate' => $cash_out_rate]);
                } else {
                    return __('currency::type.not_cash');
                }
            });
        $grid->column('cash_out_service_rate', __('currency::type.cash_out_service_rate'))
            ->suffix('')
            ->display(function ($cash_out_service_rate) {
                if ($cash_out_service_rate > 0) {
                    return $cash_out_service_rate . '/10000';
                } else {
                    return __('currency::type.service_free');
                }
            });;
        $grid->column('recharge_status', __('currency::type.recharge_status.label'))
            ->using(__('currency::type.recharge_status.value'))
            ->label(['warning', 'success']);
        $grid->column('exchange_status', __('currency::type.exchange_status.label'))
            ->using(__('currency::type.exchange_status.value'))
            ->label(['warning', 'success']);
        $grid->column('cash_out_status', __('currency::type.cash_out_status.label'))
            ->using(__('currency::type.cash_out_status.value'))
            ->label(['warning', 'success']);

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
        $show = new Show(CurrencyType::findOrFail($id));

        $show->field('id', __('currency::type.id'));
        $show->field('name', __('currency::type.name'));
        $show->field('ico', __('currency::type.ico'))->image();
        $show->field('unit', __('currency::type.unit'));
        $show->field('recharge_rate', __('currency::type.recharge_rate'));
        $show->field('cash_out_rate', __('currency::type.cash_out_rate'));
        $show->field('cash_out_service_rate', __('currency::type.cash_out_service_rate'));
        $show->field('recharge_min_amount', __('currency::type.recharge_min_amount'));
        $show->field('cash_out_max_amount', __('currency::type.cash_out_max_amount'));
        $show->field('cash_out_min_amount', __('currency::type.cash_out_min_amount'));
        $show->field('cash_out_min_rate', __('currency::type.cash_out_min_rate'));
        $show->field('cash_out_max_rate', __('currency::type.cash_out_max_rate'));
        $show->field('recharge_status', __('currency::type.recharge_status.label'))
            ->using(__('currency::type.recharge_status.value'));
        $show->field('exchange_status', __('currency::type.exchange_status.label'))
            ->using(__('currency::type.exchange_status.value'));
        $show->field('cash_out_status', __('currency::type.cash_out_status.label'))
            ->using(__('currency::type.cash_out_status.value'));
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
        $form = new Form(new CurrencyType);

        $form->text('name', __('currency::type.name'))->required();
        $form->image('ico', __('currency::type.ico'))
            ->uniqueName()
            ->removable()
            ->move('currency');
        $form->text('unit', __('currency::type.unit'))->required();
        $form->number('recharge_rate', __('currency::type.recharge_rate'))
            ->min(0)
            ->help(__('currency::type.recharge_rate_help'))
            ->required();
        $form->number('cash_out_rate', __('currency::type.cash_out_rate'))
            ->min(0)
            ->help(__('currency::type.cash_out_rate_help'))
            ->required();
        $form->number('cash_out_service_rate', __('currency::type.cash_out_service_rate'))
            ->min(0)
            ->help(__('currency::type.cash_out_service_rate_help'))
            ->required();
        $form->currency('recharge_min_amount', __('currency::type.recharge_min_amount'))
            ->help(__('currency::type.recharge_min_amount_help'))
            ->symbol(config('qihu.currency_symbol', '¥'));
        $form->currency('cash_out_max_amount', __('currency::type.cash_out_max_amount'))
            ->help(__('currency::type.cash_out_amount_help'))
            ->symbol('*');
        $form->currency('cash_out_min_amount', __('currency::type.cash_out_min_amount'))
            ->help(__('currency::type.cash_out_amount_help'))
            ->symbol('*');
        $form->currency('cash_out_min_rate', __('currency::type.cash_out_min_rate'))
            ->help(__('currency::type.cash_out_min_rate_help'))
            ->symbol(config('qihu.currency_symbol', '¥'));
        $form->currency('cash_out_max_rate', __('currency::type.cash_out_max_rate'))
            ->help(__('currency::type.cash_out_max_rate_help'))
            ->symbol(config('qihu.currency_symbol', '¥'));
        $form->select('recharge_status', __('currency::type.recharge_status.label'))
            ->options(__('currency::type.recharge_status.value'));
        $form->select('exchange_status', __('currency::type.exchange_status.label'))
            ->options(__('currency::type.exchange_status.value'));
        $form->select('cash_out_status', __('currency::type.cash_out_status.label'))
            ->options(__('currency::type.cash_out_status.value'));

        return $form;
    }
}
