<?php
/**
 * Note: 资源库基类
 * User: Liu
 * Date: 2018/4/4
 */
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;
    protected static $pageSize = 15;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function lists()
    {
        return $this->model->paginate(self::$pageSize);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findBy($field, $value)
    {
        return $this->model->where($field, $value)->first();
    }

    /**
     * 新增
     * @param array $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * 更新
     * @param array $data
     * @param string $attribute
     * @return mixed
     */
    public function update($data, $attribute = 'id')
    {
        $item = $this->find($data[$attribute]);
        return $item->update($data);
    }

    /**
     * 删除
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}