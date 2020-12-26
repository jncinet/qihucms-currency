<?php

namespace Qihucms\Currency\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Qihucms\Currency\Currency;
use Qihucms\Currency\Repositories\CashOutOrderRepository;
use Qihucms\Currency\Requests\CashOutOrder\StoreRequest;
use Qihucms\Currency\Resources\CashOutOrder\CashOutOrderCollection;
use Qihucms\Currency\Resources\CashOutOrder\CashOutOrder as CashOutOrderResource;

class CashOutOrderController extends ApiController
{
    protected $order;

    public function __construct(CashOutOrderRepository $order)
    {
        $this->middleware('auth:api');
        $this->order = $order;
    }

    /**
     * 提现记录
     *
     * @param Request $request
     * @return CashOutOrderCollection
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

        // 收款卡号
        $bank_card = $request->get('bank_card');
        if ($bank_card) {
            $condition[] = ['bank_card', '=', $bank_card];
        }

        // 提现状态
        $status = $request->get('status');
        if ($status) {
            $condition[] = ['status', '=', $status];
        }

        // 每页条数
        $limit = (int)$request->get('limit', 15);

        $result = $this->order->userOrderPaginate($condition, $limit);

        return new CashOutOrderCollection($result);
    }

    /**
     * 申请提现
     *
     * @param StoreRequest $request
     * @return CashOutOrderResource|JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $data = $request->only(['currency_type_id', 'currency_bank_card_id', 'cash_out_amount']);
        $data = array_merge(['user_id' => Auth::id(), 'status' => 0], $data);

        // 验证卡号是否属于会员
        if (!Currency::verifyUserBankCard(Auth::id(), $data['currency_bank_card_id'])) {
            return $this->jsonResponse(
                [__('currency::message.invalid_bank_card')],
                '',
                422
            );
        }

        // 验证申请是否合规
        $type = Currency::type($data['currency_type_id']);

        // 是否允许提现、提现汇率是否大于0
        if ($type->cash_out_status && $type->cash_out_rate > 0) {

            // 是否超过最小提现数额
            if ($type->cash_out_min_amount == 0 || $type->cash_out_min_amount <= $data['cash_out_amount']) {

                // 当日已提数额
                $cashedAmount = $this->order->sumUserTodayCashOutAmount(Auth::id(), $type->id);

                // 当天是否还有可提现数额
                if ($type->cash_out_max_amount == 0 || $cashedAmount < $type->cash_out_max_amount) {

                    // 计算应到账金额 = 申请提现金额 / 提现汇率
                    $toAmount = bcdiv($data['cash_out_amount'], $type->cash_out_rate, 2);

                    // 计算提现手续费
                    $serviceFee = Currency::calculateServiceFee(
                        $toAmount,
                        $type->cash_out_service_rate,
                        $type->cash_out_min_rate,
                        $type->cash_out_max_rate
                    );

                    if ($toAmount <= $serviceFee) {
                        return $this->jsonResponse(
                            [__('currency::message.amount_too_small')],
                            '',
                            422
                        );
                    }

                    // 实际到账金额
                    $recordedAmount = bcsub($toAmount, $serviceFee, 2);

                    // 当前会员账户
                    $userAccount = Currency::findUserAccountByType(Auth::id(), $type->id);

                    // 验证会员账户金额是否足够
                    if ($userAccount && $userAccount->amount < $data['cash_out_amount']) {
                        return $this->jsonResponse(
                            [__('currency::message.insufficient_balance')],
                            '',
                            422
                        );
                    }

                    // 附加数据
                    $data = array_merge($data, [
                        'rate' => $type->cash_out_rate,
                        'recorded_amount' => $recordedAmount,
                        'user_amount' => $userAccount->amount
                    ]);

                    // 创建提现订单
                    $result = $this->order->create($data);

                } else {
                    if ($type->cash_out_max_amount - $cashedAmount > 0) {
                        return $this->jsonResponse(
                            [
                                trans(
                                    'currency::message.today_amount_max',
                                    [
                                        'amount' => $type->cash_out_max_amount - $cashedAmount,
                                        'unit' => $type->unit
                                    ]
                                )
                            ],
                            '',
                            422
                        );
                    } else {
                        return $this->jsonResponse(
                            [__('currency::message.today_amount_empty')],
                            '',
                            422
                        );
                    }
                }
            } else {
                return $this->jsonResponse(
                    [
                        trans(
                            'currency::message.cash_min_amount',
                            [
                                'name' => $type->name,
                                'amount' => $type->cash_out_min_amount,
                                'unit' => $type->unit
                            ]
                        )
                    ],
                    '',
                    422
                );
            }
        } else {
            return $this->jsonResponse(
                [trans('currency::message.no_support_cash', ['name' => $type->name])],
                '',
                422
            );
        }

        // 扣除会员账户余额
        $expend = Currency::expend(
            Auth::id(),
            $data['currency_type_id'],
            $result->cash_out_amount,
            'cash-out-order',
            $result->id
        );

        // =100时，扣款成功
        if ($expend === true) {
            return new CashOutOrderResource($result);
        }

        // 删除申请订单
        $result->delete();

        return $this->jsonResponse(['tips' => $expend], '', 422);
    }

    /**
     * 提现记录详细
     *
     * @param $id
     * @return CashOutOrderResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->order->findByUserIdAndId(Auth::id(), $id);
        if ($result) {
            return new CashOutOrderResource($result);
        }

        return $this->jsonResponse(
            [__('currency::message.record_does_not_exist')],
            '',
            422
        );
    }

    /**
     * 删除提现记录
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if ($this->order->deleteByUserIdAndId(Auth::id(), $id)) {
            return $this->jsonResponse(['id' => intval($id)]);
        }
        return $this->jsonResponse([__('currency::message.delete_fail')], '', 422);
    }
}