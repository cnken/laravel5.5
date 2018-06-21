<?php
/**
 * Note: 点击数记录
 * User: Liu
 * Date: 2018/4/3
 */
namespace App\Repositories;

use App\Models\HitRecord;

class HitRecordRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new HitRecord());
    }

    /**
     * @param $startDate
     * @param null $endDate
     * @param null $aid
     * @param null $mid
     * @return mixed
     */
    public function sum($startDate, $endDate = null, $aid = null, $mid = null)
    {
        $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
        $endDate = $endDate ? $endDate : date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($startDate)));
        $query = $this->model->where('created_at', '>=', $startDate)
                    ->where('created_at', '<', $endDate);
        if ($aid) $query = $query->where('aid', $aid);
        if ($mid) $query = $query->where('mid', $mid);
        $sum = $query->sum('hits');
        return $sum;
    }

}