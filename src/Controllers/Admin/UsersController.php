<?php

namespace Qihucms\Currency\Controllers\Admin;

use App\Admin\Controllers\Controller;
use App\Models\User;
use Qihucms\Currency\Models\CurrencyType;
use Qihucms\Currency\Models\CurrencyUser;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UsersController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '会员账户';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CurrencyUser);

        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->equal('user_id', __('currency::user.user_id'));
            $filter->equal('currency_type_id', __('currency::user.currency_type_id'))
                ->select(CurrencyType::all()->pluck('name', 'id'));
            $filter->between('amount', __('currency::user.amount'));
        });

        $grid->column('id', __('currency::user.id'));
        $grid->column('user.username', __('user.username'));
        $grid->column('currency_type.name', __('currency::type.name'));
        $grid->column('amount', __('currency::user.amount'));

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
        $show = new Show(CurrencyUser::findOrFail($id));

        $show->field('id', __('currency::user.id'));
        $show->field('user_id', __('currency::user.user_id'))->as(function () {
            return $this->user->username ?? trans('currency::message.record_does_not_exist');
        });
        $show->field('currency_type_id', __('currency::user.currency_type_id'))->as(function () {
            return $this->currency_type->name ?? trans('currency::message.record_does_not_exist');
        });
        $show->field('amount', __('currency::user.amount'));
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
        $form = new Form(new CurrencyUser);

        $form->select('user_id', __('currency::user.user_id'))
            ->options(function ($id) {
                $user = User::find($id);
                if ($user) {
                    return [$user->id => $user->username];
                }
            })
            ->ajax(route('api.article.select.users.q'))
            ->required();
        $form->select('currency_type_id', __('currency::user.currency_type_id'))
            ->options(CurrencyType::all()->pluck('name', 'id'))
            ->required();
        $form->text('amount', __('currency::user.amount'))->required();

        return $form;
    }
}
