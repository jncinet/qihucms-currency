<?php

namespace Qihucms\Currency\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Qihucms\Currency\Repositories\BankCardRepository;
use Qihucms\Currency\Requests\BankCard\StoreRequest;
use Qihucms\Currency\Requests\BankCard\UpdateRequest;
use Qihucms\Currency\Resources\BankCard\BankCard as BankCardResource;
use Qihucms\Currency\Resources\BankCard\BankCardCollection;

class BankCardController extends Controller
{
    protected $bankCard;

    public function __construct(BankCardRepository $bankCard)
    {
        $this->middleware('auth:api')->except(['adminFindBankCardById']);
        $this->bankCard = $bankCard;
    }

    /**
     * 后台选择会员收款卡号
     *
     * @param Request $request
     * @return mixed
     */
    public function adminFindBankCardById(Request $request)
    {
        $user_id = $request->get('q');
        return $this->bankCard->selectNameAndIdById($user_id);
    }

    /**
     * 会员所有收款卡号
     *
     * @return BankCardCollection
     */
    public function index()
    {
        $result = $this->bankCard->findCardByUserPaginate(Auth::id());

        return new BankCardCollection($result);
    }

    /**
     * 添加卡号
     *
     * @param StoreRequest $request
     * @return BankCardResource
     */
    public function store(StoreRequest $request)
    {
        $data = $request->only(['name', 'bank', 'mobile', 'account']);
        $data = array_merge(['user_id' => Auth::id()], $data);
        $result = $this->bankCard->create($data);

        return new BankCardResource($result);
    }

    /**
     * 卡号详细
     *
     * @param $id
     * @return BankCardResource|JsonResponse
     */
    public function show($id)
    {
        $result = $this->bankCard->findCardByUserIdAndId(Auth::id(), $id);
        if ($result) {
            return new BankCardResource($result);
        }

        return $this->jsonResponse([trans('record_does_not_exist')], '', 422);
    }

    /**
     * 更新卡号
     *
     * @param UpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        $condition = [
            ['user_id', '=', Auth::id()],
            ['id', '=', $id],
        ];

        $data = $request->only(['name', 'bank', 'mobile', 'account']);

        if ($this->bankCard->update($condition, $data)) {
            return $this->jsonResponse(['id' => intval($id)]);
        }

        return $this->jsonResponse([trans('currency::message.update_fail')], '', 422);
    }

    /**
     * 删除卡号
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if ($this->bankCard->destroy(Auth::id(), $id)) {
            return $this->jsonResponse(['id' => intval($id)]);
        }

        return $this->jsonResponse([trans('currency::message.delete_fail')], '', 422);
    }
}