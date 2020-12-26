<?php

use Illuminate\Routing\Router;

// 接口
Route::group([
    'prefix' => config('qihu.currency_prefix', 'currency'),
    'namespace' => 'Qihucms\Currency\Controllers\Api',
    'middleware' => ['api'],
    'as' => 'api.current.'
], function (Router $router) {
    $router->get('admin-currency-bank-cards', 'BankCardController@adminFindBankCardById')
        ->name('payment.currency_bank_card.admin');
    $router->apiResource('bank-cards', 'BankCardController');
    $router->apiResource('cash-out-orders', 'CashOutOrderController')->except(['update']);
    $router->apiResource('exchange-orders', 'ExchangeOrderController')->except(['update']);
    $router->apiResource('recharge-orders', 'RechargeOrderController');
    $router->apiResource('types', 'ExchangeController')->only(['index', 'show']);
    $router->apiResource('exchanges', 'ExchangeController')->only(['index', 'show']);
    $router->apiResource('users', 'UserController')->only(['index', 'show']);
    $router->apiResource('user-logs', 'UserLogController')->only(['index', 'show']);
});

// 后台管理
Route::group([
    'prefix' => config('admin.route.prefix') . '/currency',
    'namespace' => 'Qihucms\Currency\Controllers\Admin',
    'middleware' => config('admin.route.middleware'),
    'as' => 'admin.currency.'
], function (Router $router) {
    $router->resource('bank-cards', 'BankCardsController');
    $router->resource('users', 'UsersController');
    $router->resource('user-logs', 'UserLogsController');
    $router->resource('types', 'TypesController');
    $router->resource('exchanges', 'ExchangesController');
    $router->resource('exchange-orders', 'ExchangeOrdersController');
    $router->resource('recharge-orders', 'RechargeOrdersController');
    $router->resource('cash-out-orders', 'CashOutOrdersController');
});