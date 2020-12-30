<?php

namespace Qihucms\Currency\Controllers\Admin;

use App\Admin\Controllers\Controller;
use App\Models\User;
use Qihucms\Currency\Models\CurrencyType;
use Qihucms\Currency\Models\CurrencyUserLog;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserLogsController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '账户流水';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CurrencyUserLog);

        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->equal('user_id', __('currency::user_log.user_id'));
            $filter->equal('currency_type_id', __('currency::user_log.currency_type_id'))
                ->select(CurrencyType::all()->pluck('name', 'id'));
            $filter->equal('trigger_event', __('currency::user_log.trigger_event'));
            $filter->equal('order_id', __('currency::user_log.order_id'));
            $filter->between('amount', __('currency::user_log.amount'));
        });

        $grid->column('id', __('currency::user_log.id'));
        $grid->column('user.username', __('user.username'));
        $grid->column('currency_type.name', __('currency::type.name'));
        $grid->column('trigger_event', __('currency::user_log.trigger_event'));
        $grid->column('order_id', __('currency::user_log.order_id'));
        $grid->column('amount', __('currency::user_log.amount'));
        $grid->column('user_current_amount', __('currency::user_log.user_current_amount'));

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
        $show = new Show(CurrencyUserLog::findOrFail($id));

        $show->field('id', __('currency::user_log.id'));
        $show->field('user_id', __('currency::user_log.user_id'))->as(function () {
            return $this->user->username ?? trans('currency::message.record_does_not_exist');
        });
        $show->field('currency_type_id', __('currency::user_log.currency_type_id'))->as(function () {
            return $this->currency_type->name ?? trans('currency::message.record_does_not_exist');
        });
        $show->field('trigger_event', __('currency::user_log.trigger_event'));
        $show->field('order_id', __('currency::user_log.order_id'));
        $show->field('amount', __('currency::user_log.amount'));
        $show->field('user_current_amount', __('currency::user_log.user_current_amount'));
        $show->field('desc', __('currency::user_log.desc'));
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
        $form = new Form(new CurrencyUserLog);

        $form->select('user_id', __('currency::user_log.user_id'))
            ->options(function ($id) {
                $user = User::find($id);
                if ($user) {
                    return [$user->id => $user->username];
                }
            })
            ->ajax(route('admin.user.select'))
            ->required();
        $form->select('currency_type_id', __('currency::user_log.currency_type_id'))
            ->options(CurrencyType::all()->pluck('name', 'id'))
            ->required();
        $form->text('trigger_event', __('currency::user_log.trigger_event'))->required();
        $form->text('order_id', __('currency::user_log.order_id'));
        $form->currency('amount', __('currency::user_log.amount'))
            ->symbol('¥');
        $form->currency('user_current_amount', __('currency::user_log.user_current_amount'))
            ->symbol('¥');
        $form->textarea('desc', __('currency::user_log.desc'));

        return $form;
    }
}
