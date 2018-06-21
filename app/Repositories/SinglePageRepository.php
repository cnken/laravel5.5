<?php
/**
 * Note: 单页
 * User: Liu
 * Date: 2018/4/11
 */
namespace App\Repositories;

use App\Models\SinglePage;
use App\Models\SinglePageContent;

class SinglePageRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new SinglePage());
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function find($id)
    {
        return $this->model->with('content')->find($id);
    }

    /**
     * 新增
     * @param array $data
     * @return bool|mixed
     */
    public function create($data)
    {
        $item = $this->model->create($data);
        if ($item) {
            return $item->content()->create([
                'content' => $data['content']
            ]);
        }
        return false;
    }

    /**
     * 更新
     * @param array $data
     * @return bool|mixed
     */
    public function update($data)
    {
        $item = $this->model->find($data['id']);
        $item->update($data);
        $item->content()->save(new SinglePageContent([
            'content' => $data['content']
        ]));

        return true;
    }

    /**
     * 获取各个状态的文章数量
     * @return array
     */
    public function get_status_num()
    {
        $data = [];
        $data['0'] = $this->model->where('status',0)->count();
        $data['1'] = $this->model->where('status',1)->count();
        $data['2'] = $this->model->where('status',2)->count();
        return $data;
    }

    /**
     * @param $where
     * @param bool $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function lists($where = [], $page = true)
    {
        if (!empty($where['keyword'])) {
            $keyword = $where['keyword'];
            unset($where['keyword']);
        }
        $query = $this->model->where($where);
        if (isset($keyword)) $query = $query->title($keyword);
        return $page ? $query->paginate(self::$pageSize) : $query->get();
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return $this->model->count();
    }

    /**
     * @return mixed
     */
    public function dailyInsertCount()
    {
        return $this->model->where('created_at', '>', date('Y-m-d 00:00:00'))->count();
    }
}