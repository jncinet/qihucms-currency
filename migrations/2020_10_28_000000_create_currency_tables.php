<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 货币类型
        Schema::create('currency_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->comment('货币名称');
            $table->string('ico', 100)->comment('小图标');
            $table->string('unit')->comment('单位');
            $table->unsignedInteger('recharge_rate')->default(0)->comment('1RMB=？');
            $table->unsignedInteger('cash_out_rate')->default(0)->comment('？=1RMB');
            $table->unsignedInteger('cash_out_service_rate')->default(0)->comment('提现手续费比例');
            $table->unsignedDecimal('recharge_min_amount', 10, 2)
                ->default(0)->comment('最小充值金额');
            $table->unsignedDecimal('cash_out_max_amount', 10, 2)
                ->default(0)->comment('每日最高提现');
            $table->unsignedDecimal('cash_out_min_amount', 10, 2)
                ->default(0)->comment('每笔最低提现');
            $table->unsignedDecimal('cash_out_min_rate', 10, 2)
                ->default(0)->comment('单笔最低手续费');
            $table->unsignedDecimal('cash_out_max_rate', 10, 2)
                ->default(0)->comment('单笔最高手续费');
            $table->boolean('recharge_status')->default(0)->comment('是否可以充值');
            $table->boolean('exchange_status')->default(0)->comment('是否可以兑换');
            $table->boolean('cash_out_status')->default(0)->comment('是否可以提现');
            $table->timestamps();
        });

        // 会员账户
        Schema::create('currency_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('会员');
            $table->unsignedBigInteger('currency_type_id')->index()->comment('货币类型');
            $table->unsignedDecimal('amount', 10, 2)
                ->default(0)->comment('金额');
            $table->timestamps();
        });

        // 货币支持的相互兑换类型
        Schema::create('currency_exchanges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('currency_type_id')->index()->comment('兑换？');
            $table->unsignedBigInteger('currency_type_to_id')->index()->comment('兑换成？');
            $table->unsignedInteger('rate')->default(0)->comment('兑换汇率');
            $table->unsignedDecimal('exchange_max_amount', 10, 2)
                ->default(0)->comment('每日最大兑换金额');
            $table->timestamps();
        });

        // 兑换订单记录
        Schema::create('currency_exchange_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('兑换会员');
            $table->unsignedBigInteger('currency_exchange_id')->index()->comment('兑换类型');
            $table->unsignedInteger('rate')->default(0)->comment('兑换汇率');
            $table->unsignedDecimal('exchange_amount', 10, 2)
                ->default(0)->comment('兑换金额');
            $table->unsignedDecimal('recorded_amount', 10, 2)
                ->default(0)->comment('到账金额');
            $table->unsignedDecimal('user_amount', 10, 2)
                ->default(0)->comment('会员账户金额');
            $table->boolean('status')->default(0)->comment('兑换状态');
            $table->timestamps();
        });

        // 充值订单记录
        Schema::create('currency_recharge_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('充值会员');
            $table->unsignedBigInteger('currency_type_id')->index()->comment('充值类型');
            $table->unsignedInteger('rate')->default(0)->comment('充值汇率');
            $table->unsignedDecimal('recharge_amount', 10, 2)
                ->default(0)->comment('充值金额');
            $table->unsignedDecimal('recorded_amount', 10, 2)
                ->default(0)->comment('到账金额');
            $table->unsignedDecimal('user_amount', 10, 2)
                ->default(0)->comment('会员账户金额');
            $table->boolean('status')->default(0)->comment('充值状态');
            $table->timestamps();
        });

        // 提现订单记录
        Schema::create('currency_cash_out_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('提现会员');
            $table->unsignedBigInteger('currency_type_id')->index()->comment('提现类型');
            $table->unsignedBigInteger('currency_bank_card_id')->index()->comment('收款账号');
            $table->unsignedInteger('rate')->default(0)->comment('提现汇率');
            $table->unsignedDecimal('cash_out_amount', 10, 2)
                ->default(0)->comment('提现金额');
            $table->unsignedDecimal('recorded_amount', 10, 2)
                ->default(0)->comment('到账金额');
            $table->unsignedDecimal('user_amount', 10, 2)
                ->default(0)->comment('会员账户金额');
            $table->boolean('status')->default(0)->comment('提现状态');
            $table->timestamps();
        });

        // 账户流水
        Schema::create('currency_user_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('交易会员');
            $table->unsignedBigInteger('currency_type_id')->index()->comment('货币类型');
            $table->string('trigger_event')->index()->comment('触发事件');
            $table->string('order_id')->index()->comment('订单号');
            $table->decimal('amount', 10, 2)->comment('交易数额');
            $table->unsignedDecimal('user_current_amount', 10, 2)
                ->comment('当前会员账户金额');
            $table->string('desc')->nullable()->comment('备注');
            $table->timestamps();
        });

        // 会员收款卡号
        Schema::create('currency_bank_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment('会员的ID');
            $table->string('name', 66)->comment('开户名');
            $table->string('bank')->comment('开户行');
            $table->char('mobile', 11)->nullable()->comment('预留手机号');
            $table->string('account')->comment('账号');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currency_types');
        Schema::dropIfExists('currency_users');
        Schema::dropIfExists('currency_exchanges');
        Schema::dropIfExists('currency_exchange_orders');
        Schema::dropIfExists('currency_recharge_orders');
        Schema::dropIfExists('currency_cash_out_orders');
        Schema::dropIfExists('currency_users_logs');
        Schema::dropIfExists('currency_bank_cards');
    }
}
