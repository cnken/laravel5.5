<?php
/**
 * Note: 管理员管理
 * User: Liu
 * Date: 2018/3/18
 * Time: 11:47
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\ManagerStore;
use App\Repositories\ManagerRepository;
use App\Repositories\RolesRepository;

class ManagerController extends Controller
{
    /**
     * 列表
     * @param ManagerRepository $repository
     * @return mixed
     */
    public function getIndex(ManagerRepository $repository)
    {
        $lists = $repository->list();
        $data = [
            'lists' => $lists,
        ];
        return admin_view('manager.index' , $data);
    }

    /**
     * @param \Request $request
     * @param ManagerRepository $repository
     * @param RolesRepository $rolesRepository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doCreate(\Request $request, ManagerRepository $repository, RolesRepository $rolesRepository)
    {
        if ($request::isMethod('get')) {
            $data = [
                'roles' => $rolesRepository->listBy(['status' => 1], false)
            ];
            return admin_view('manager.create', $data);
        }
        $data = $request::all();
        $data['avatar'] = upload_base64_thumb($data['avatar']);

        $validator = ManagerStore::validateCreate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->create($data)) {
            return redirect()->route('admin.manager.index')->with('Message' , '添加成功');
        } else {
            return back()->withErrors('添加失败')->withInput();
        }
    }

    /**
     * 更新
     * @param \Request $request
     * @param ManagerRepository $repository
     * @param RolesRepository $rolesRepository
     * @return $this|\Illuminate\Http\RedirectResponse|mixed
     */
    public function doUpdate(\Request $request, ManagerRepository $repository, RolesRepository $rolesRepository)
    {
        if ($request::isMethod('get')) {
            $data = $repository->find($request::input('id'));
            $data['roles'] = $rolesRepository->listBy(['status' => 1], false);
            return admin_view('manager.create', $data);
        }
        $data = $request::all();
        $data['avatar'] = upload_base64_thumb($data['avatar']);
        if (empty($data['password'])) unset($data['password']);

        $validator = ManagerStore::validateUpdate($data);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($repository->update($data)) {
            return redirect()->route('admin.manager.index')->with('Message' , '更新成功');
        } else {
            return back()->withErrors('更新失败')->withInput();
        }
    }

    /**
     * 删除
     * @param \Request $request
     * @param ManagerRepository $repository
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function getDelete(\Request $request, ManagerRepository $repository)
    {
        $data = $request::all();
        if ($repository->delete($data['id'])) {
            return redirect()->route('admin.manager.index')->with('Message' , '删除成功');
        } else {
            return back()->withErrors('删除失败')->withInput();
        }
    }
}