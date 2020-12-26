<?php

namespace Qihucms\Currency\Controllers\Admin;

use App\Admin\Controllers\Controller;
use App\Models\User;
use Qihucms\Currency\Models\CurrencyBankCard;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BankCardsController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '会员收款账号';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CurrencyBankCard);

        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->equal('user_id', __('currency::bank_card.user_id'));
            $filter->equal('name', __('currency::bank_card.name'));
            $filter->equal('bank', __('currency::bank_card.bank'));
            $filter->equal('mobile', __('currency::bank_card.mobile'));
            $filter->equal('account', __('currency::bank_card.account'));
        });

        $grid->column('id', __('currency::bank_card.id'));
        $grid->column('user.nickname', __('user.nickname'));
        $grid->column('name', __('currency::bank_card.name'));
        $grid->column('bank', __('currency::bank_card.bank'));
        $grid->column('mobile', __('currency::bank_card.mobile'));
        $grid->column('account', __('currency::bank_card.account'));

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
        $show = new Show(CurrencyBankCard::findOrFail($id));

        $show->field('id', __('currency::bank_card.id'));
        $show->field('user_id', __('currency::bank_card.user_id'))->as(function () {
            return $this->user->nickname ?? trans('currency::message.record_does_not_exist');
        });
        $show->field('name', __('currency::bank_card.name'));
        $show->field('bank', __('currency::bank_card.bank'));
        $show->field('mobile', __('currency::bank_card.mobile'));
        $show->field('account', __('currency::bank_card.account'));
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
        $form = new Form(new CurrencyBankCard);

        $form->select('user_id', __('currency::bank_card.user_id'))
            ->options(function ($id) {
                $user = User::find($id);
                if ($user) {
                    return [$user->id => $user->username];
                }
            })
            ->ajax(route('api.article.select.users.q'))
            ->required();
        $form->text('name', __('currency::bank_card.name'))->required();
        $form->text('bank', __('currency::bank_card.bank'))->required();
        $form->mobile('mobile', __('currency::bank_card.mobile'));
        $form->text('account', __('currency::bank_card.account'))->required();

        return $form;
    }
}
