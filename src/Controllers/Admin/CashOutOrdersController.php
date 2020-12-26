<?php

namespace Qihucms\Currency\Controllers\Admin;

use App\Admin\Controllers\Controller;
use App\Models\User;
use Qihucms\Currency\Models\CurrencyBankCard;
use Qihucms\Currency\Models\CurrencyCashOutOrder;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Qihucms\Currency\Models\CurrencyType;

class CashOutOrdersController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '提现管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CurrencyCashOutOrder);

        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->equal('user_id', __('currency::cash_out_order.user_id'));
            $filter->equal('currency_type_id', __('currency::cash_out_order.currency_type_id'))
                ->select(CurrencyType::all()->pluck('name', 'id'));
            $filter->equal('currency_bank_card_id', __('currency::cash_out_order.currency_bank_card_id') . 'ID');
            $filter->between('rate', __('currency::cash_out_order.rate'));
            $filter->between('cash_out_amount', __('currency::cash_out_order.cash_out_amount'));
            $filter->between('recorded_amount', __('currency::cash_out_order.recorded_amount'));
        });

        $grid->column('id', __('currency::cash_out_order.id'));
        $grid->column('user.nickname', __('user.nickname'));
        $grid->column('currency_type.name', __('currency::type.name'));
        $grid->column('currency_bank_card', __('currency::type.name'))
            ->display(function () {
                $html = '';
                if ($this->currency_bank_card) {
                    $html .= '<div>' . __('currency::bank_card.name') . '：' . $this->currency_bank_card->name . '</div>';
                    $html .= '<div>' . __('currency::bank_card.bank') . '：' . $this->currency_bank_card->bank . '</div>';
                    $html .= '<div>' . __('currency::bank_card.mobile') . '：' . $this->currency_bank_card->mobile . '</div>';
                    $html .= '<div>' . __('currency::bank_card.account') . '：' . $this->currency_bank_card->account . '</div>';
                }
                return $html;
            });
        $grid->column('rate', __('currency::cash_out_order.rate'))->suffix('=1RMB');
        $grid->column('cash_out_amount', __('currency::cash_out_order.cash_out_amount'));
        $grid->column('recorded_amount', __('currency::cash_out_order.recorded_amount'))->suffix('RMB');
        $grid->column('user_amount', __('currency::cash_out_order.user_amount'));
        $grid->column('status', __('currency::cash_out_order.status.label'))
            ->using(__('currency::cash_out_order.status.value'));

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
        $show = new Show(CurrencyCashOutOrder::findOrFail($id));

        $show->field('id', __('currency::cash_out_order.id'));
        $show->field('user_id', __('currency::cash_out_order.user_id'))
            ->as(function () {
                return $this->user->nickname ?? trans('currency::message.record_does_not_exist');
            });
        $show->field('currency_type', __('currency::cash_out_order.currency_type_id'))
            ->as(function () {
                return $this->currency_type->name ?? trans('currency::message.record_does_not_exist');
            });
        $show->field('currency_bank_card', __('currency::cash_out_order.currency_bank_card_id'))
            ->unescape()
            ->as(function () {
                $html = '';
                if ($this->currency_bank_card) {
                    $html .= '<div>' . __('currency::bank_card.name') . '：' . $this->currency_bank_card->name . '</div>';
                    $html .= '<div>' . __('currency::bank_card.bank') . '：' . $this->currency_bank_card->bank . '</div>';
                    $html .= '<div>' . __('currency::bank_card.mobile') . '：' . $this->currency_bank_card->mobile . '</div>';
                    $html .= '<div>' . __('currency::bank_card.account') . '：' . $this->currency_bank_card->account . '</div>';
                }
                return $html;
            });
        $show->field('rate', __('currency::cash_out_order.rate'));
        $show->field('cash_out_amount', __('currency::cash_out_order.cash_out_amount'));
        $show->field('recorded_amount', __('currency::cash_out_order.recorded_amount'));
        $show->field('user_amount', __('currency::cash_out_order.user_amount'));
        $show->field('status', __('currency::cash_out_order.status.label'))
            ->using(__('currency::cash_out_order.status.value'));
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
        $form = new Form(new CurrencyCashOutOrder);

        $form->select('user_id', __('currency::cash_out_order.user_id'))
            ->options(function ($id) {
                $user = User::find($id);
                if ($user) {
                    return [$user->id => $user->username];
                }
            })
            ->ajax(route('api.article.select.users.q'))
            ->required();
        $form->select('currency_type_id', __('currency::cash_out_order.currency_type_id'))
            ->options(CurrencyType::all()->pluck('name', 'id'))
            ->required();
        $form->select('currency_bank_card_id', __('currency::cash_out_order.currency_bank_card_id'))
            ->options(function ($id) {
                $model = CurrencyBankCard::find($id);
                if ($model) {
                    return [$model->id => $model->bank . '|' . $model->name . '|' . $model->account];
                }
            })
            ->ajax(route('api.currency.payment.currency_bank_card.admin'))
            ->required();
        $form->rate('rate', __('currency::cash_out_order.rate'))->default(100)->required();
        $form->currency('cash_out_amount', __('currency::cash_out_order.cash_out_amount'))
            ->symbol(config('qihu.currency_symbol', '¥'))->required();
        $form->currency('recorded_amount', __('currency::cash_out_order.recorded_amount'))
            ->symbol(config('qihu.currency_symbol', '¥'))->required();
        $form->currency('user_amount', __('currency::cash_out_order.user_amount'))
            ->symbol('*')->required();
        $form->select('status', __('currency::cash_out_order.status.label'))
            ->options(__('currency::cash_out_order.status.value'));

        return $form;
    }
}
