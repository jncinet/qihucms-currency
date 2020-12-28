<?php

namespace Qihucms\Currency\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Qihucms\Currency\Currency;
use Qihucms\Currency\Requests\RechargeOrder\StoreRequest;
use Qihucms\Currency\Resources\RechargeOrder\RechargeOrder as RechargeOrderResource;
use Qihucms\Currency\Resources\RechargeOrder\RechargeOrderCollection;
use Qihucms\Currency\Repositories\RechargeOrderRepository;

class RechargeOrderController extends Controller
{
    protected $order;

    public function __construct(RechargeOrderRepository $order)
    {
        $this->middleware('auth:api');
        $this->order = $order;
    }

    /**
     * 充值记录
     *
     * @param Request $request
     * @return RechargeOrderCollection
     */
    public function index(Request $request)
    {
        $condition = [
            ['user_id', '=', Auth::id()]
        ];

        // 货币类型
        $type = (int)$request->get('type');
        if ($type) {
            $condition[] = ['currency_type_id', '=', $type];
        }

        // 提现状态
        $status = $request->get('status');
        if ($status) {
            $condition[] = ['status', '=', $status];
        }

        // 每页条数
        $limit = (int)$request->get('limit', 15);

        $result = $this->order->userOrderPaginate($condition, $limit);

        return new RechargeOrderCollection($result);
    }

    /**
     * 创建充值订单
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse|RechargeOrderResource
     */
    public function store(StoreRequest $request)
    {
        $data = $request->only(['currency_type_id', 'recharge_amount']);
        $data = array_merge(['user_id' => Auth::id(), 'status' => 0], $data);

        // 验证申请是否合规
        $type = Currency::type($data['currency_type_id']);

        // 是否允许充值、充值汇率是否大于0
        if ($type->recharge_status && $type->recharge_rate > 0) {

            // 是否超过最小提现数额
            if ($type->recharge_min_amount == 0 || $type->recharge_min_amount <= $data['recharge_amount']) {

                // 计算应到账金额 = 充值金额 * 充值汇率
                $toAmount = bcmul($data['recharge_amount'], $type->recharge_rate, 2);

                // 当前会员账户
                $userAccount = Currency::findUserAccountByType(Auth::id(), $type->id);

                // 附加数据
                $data = array_merge($data, [
                    'rate' => $type->recharge_rate,
                    'recorded_amount' => $toAmount,
                    'user_amount' => $userAccount->amount
                ]);

                // 创建充值订单
                $result = $this->order->create($data);

                if ($result) {
                    return new RechargeOrderResource($result);
                }

                return $this->jsonResponse(
                    [__('currency::message.recharge_order_create_fail')],
                    '',
                    422
                );
            } else {
                return $this->jsonResponse(
                    [
                        trans(
                            'currency::message.recharge_amount_min',
                            ['name' => $type->name, 'amount' => $type->recharge_min_amount]
                        )
                    ],
                    '',
                    422
                );
            }
        } else {
            return $this->jsonResponse(
                [trans('currency::message.recharge_no_support', ['name' => $type->name])],
                '',
                422
            );
        }
    }

    /**
     * 充值详细
     *
     * @param $id
     * @return RechargeOrderResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->order->findByUserIdAndId(Auth::id(), $id);
        if ($result) {
            $result->pay_order()->create([
                'user_id' => $result->user_id,
                'driver' => 'alipay',
                'gateway' => 'app',
                'type' => 'pay',
                'subject' => __('currency::message.recharge_subject'),
                'total_amount' => $result->recharge_amount,
                'params' => ['home_url' => 'http://www.baidu.com']
            ]);
            return new RechargeOrderResource($result);
        }

        return $this->jsonResponse(
            [__('currency::message.record_does_not_exist')],
            '',
            422
        );
    }

    /**
     * @param Request $request 获取支付参数
     * @param int $id 充值订单ID
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * 删除充值记录
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