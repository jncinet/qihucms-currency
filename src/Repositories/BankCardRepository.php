<?php

namespace Qihucms\Currency\Repositories;

use Qihucms\Currency\Models\CurrencyBankCard;

class BankCardRepository
{
    protected $bankCard;

    public function __construct(CurrencyBankCard $bankCard)
    {
        $this->bankCard = $bankCard;
    }

    /**
     * 后台选择会员收款卡号
     *
     * @param $user_id
     * @return mixed
     */
    public function selectNameAndIdById($user_id)
    {
        return $this->bankCard->select('id', 'name as text')
            ->where('user_id', $user_id)
            ->paginate();
    }

    /**
     * 会员卡号
     *
     * @param $user_id
     * @param int $limit
     * @return mixed
     */
    public function findCardByUserPaginate($user_id, $limit = 10)
    {
        return $this->bankCard->where('user_id', $user_id)->latest()->paginate($limit);
    }

    /**
     * 添加会员收款卡号
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data = [])
    {
        return $this->bankCard->create($data);
    }

    /**
     * 获取卡号详细
     *
     * @param $user_id
     * @param $id
     * @return mixed
     */
    public function findCardByUserIdAndId($user_id, $id)
    {
        return $this->bankCard->where('user_id', $user_id)->where('id', $id)->first();
    }

    /**
     * 更新信息
     *
     * @param array $condition
     * @param array $data
     * @return mixed
     */
    public function update(array $condition, array $data)
    {
        return $this->bankCard->where($condition)->update($data);
    }

    /**
     * 删除卡号
     *
     * @param $user_id
     * @param $id
     * @return mixed
     */
    public function destroy($user_id, $id)
    {
        return $this->bankCard->where('user_id', $user_id)->where('id', $id)->delete();
    }
}