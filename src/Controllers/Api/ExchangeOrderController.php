<?php

namespace Qihucms\Currency\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Qihucms\Currency\Currency;
use Qihucms\Currency\Repositories\ExchangeOrderRepository;
use Qihucms\Currency\Requests\ExchangeOrder\StoreRequest;
use Qihucms\Currency\Resources\ExchangeOrder\ExchangeOrderCollection;
use Qihucms\Currency\Resources\ExchangeOrder\ExchangeOrder as ExchangeOrderResource;

class ExchangeOrderController extends Controller
{
    protected $order;

    public function __construct(ExchangeOrderRepository $order)
    {
        $this->middleware('auth:api');
        $this->order = $order;
    }

    /**
     * 兑换记录
     *
     * @param Request $request
     * @return ExchangeOrderCollection
     */
    public function index(Request $request)
    {
        $condition = [
            ['user_id', '=', Auth::id()]
        ];

        // 兑换类型
        $currency_exchange_id = (int)$request->get('currency_exchange_id');
        if ($currency_exchange_id) {
            $condition[] = ['currency_exchange_id', '=', $currency_exchange_id];
        }

        // 兑换状态
        $status = $request->get('status');
        if ($status) {
            $condition[] = ['status', '=', $status];
        }

        // 每页条数
        $limit = (int)$request->get('limit', 15);

        $result = $this->order->userOrderPaginate($condition, $limit);

        return new ExchangeOrderCollection($result);
    }

    /**
     * 创建兑换订单
     *
     * @param StoreRequest $request
     * @return JsonResponse|ExchangeOrderResource
     */
    public function store(StoreRequest $request)
    {
        $data = $request->only(['currency_exchange_id', 'exchange_amount']);
        $data = array_merge(['user_id' => Auth::id(), 'status' => 0], $data);

        // 读取兑换规则
        $exchange = Currency::exchange($data['currency_exchange_id']);

        if ($exchange) {

            // 读取会员兑换类型账户
            $userTypeXAmount = Currency::findUserAccountByType(Auth::id(), $exchange->currency_type_id);

            // 验证账户余额是否充足，账户金额必须大于等于当前要兑换的金额
            if ($userTypeXAmount && $userTypeXAmount->amount >= $data['exchange_amount']) {

                // 当天已经兑换的金额
                $todayAmount = $this->order->sumUserTodayExchangeAmount(Auth::id(), $exchange->id);

                // 验证是否超出每日兑换限制
                if ($exchange->exchange_max_amount > 0
                    && $exchange->exchange_max_amount < $todayAmount + $data['exchange_amount']) {
                    return $this->jsonResponse(
                        [
                            trans(
                                'currency::message.exchange_amount_max',
                                ['amount' => $exchange->exchange_max_amount]
                            )
                        ],
                        '',
                        422
                    );
                }

                // 实际到账金额 = 兑出金额 * 10000 / 汇率
                $recordedAmount = bcmul($data['exchange_amount'], $exchange->rate, 2);
                $recordedAmount = bcdiv($recordedAmount, 10000, 2);

                // 附加数据
                $data = array_merge($data, [
                    'rate' => $exchange->rate,
                    'recorded_amount' => $recordedAmount,
                    'user_amount' => $userTypeXAmount->amount
                ]);

                // 创建订单
                $result = $this->order->create($data);

                if ($result) {
                    // X类型出账
                    $resultX = Currency::expend(
                        $result->user_id,
                        $exchange->currency_type_id,
                        $data['exchange_amount'],
                        'exchange-order',
                        $result->id
                    );

                    if ($resultX === true) {
                        // Y类型入账
                        $resultY = Currency::entry(
                            $result->user_id,
                            $exchange->currency_type_to_id,
                            $recordedAmount,
                            'exchange-order',
                            $result->id
                        );

                        if ($resultY === true) {
                            // 更新订单
                            $result->status = 1;
                            $result->save();

                            return new ExchangeOrderResource($result);
                        } else {
                            // 记录错误
                            $result->status = 2;
                            $result->desc = __('currency::message.before_accounting') . $resultY;
                            $result->save();

                            return $this->jsonResponse([$resultY], '', 422);
                        }
                    } else {
                        // 记录错误
                        $result->status = 2;
                        $result->desc = __('currency::message.after_accounting') . $resultX;
                        $result->save();

                        return $this->jsonResponse([$resultX], '', 422);
                    }
                }
            }
        }

        return $this->jsonResponse([__('currency::message.exchange_fail')], '', 422);
    }

    /**
     * 兑换详细
     *
     * @param $id
     * @return ExchangeOrderResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->order->findByUserIdAndId(Auth::id(), $id);
        if ($result) {
            return new ExchangeOrderResource($result);
        }

        return $this->jsonResponse([__('currency::message.record_does_not_exist')], '', 422);
    }

    /**
     * 删除兑换记录
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if ($this->order->deleteByUserIdAndId(Auth::id(), $id)) {
            return $this->jsonResponse(['user_id' => Auth::id(), 'id' => $id]);
        }

        return $this->jsonResponse([__('currency::message.delete_fail')], '', 422);
    }
}