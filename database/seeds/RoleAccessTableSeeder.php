<?php

use Illuminate\Database\Seeder;

class RoleAccessTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('role_access')->delete();
        
        \DB::table('role_access')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '所有权限',
                'route' => '*',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '文章发布',
                'route' => 'article.create',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '文章编辑',
                'route' => 'article.update',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '文章删除',
                'route' => 'article.delete',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => '文章列表',
                'route' => 'article.index',
            ),
            5 => 
            array (
                'id' => 8,
                'name' => '权限管理',
                'route' => 'roleaccess',
            ),
            6 => 
            array (
                'id' => 9,
                'name' => '会员组管理',
                'route' => 'rolegroup',
            ),
            7 => 
            array (
                'id' => 10,
                'name' => '单页列表',
                'route' => 'single.index',
            ),
            8 => 
            array (
                'id' => 11,
                'name' => '单页发布',
                'route' => 'single.create',
            ),
            9 => 
            array (
                'id' => 12,
                'name' => '单页编辑',
                'route' => 'single.update',
            ),
            10 => 
            array (
                'id' => 13,
                'name' => '单页删除',
                'route' => 'single.delete',
            ),
            11 => 
            array (
                'id' => 14,
                'name' => '管理员管理',
                'route' => 'manager',
            ),
            12 => 
            array (
                'id' => 15,
                'name' => '基本设置',
                'route' => 'setting.index',
            ),
            13 => 
            array (
                'id' => 16,
                'name' => '数据管理',
                'route' => 'database',
            ),
            14 => 
            array (
                'id' => 17,
                'name' => '广告管理',
                'route' => 'ad',
            ),
            15 => 
            array (
                'id' => 18,
                'name' => '分类管理',
                'route' => 'category',
            ),
            16 => 
            array (
                'id' => 19,
                'name' => '系统日志',
                'route' => 'log-viewer',
            ),
            17 => 
            array (
                'id' => 20,
                'name' => '后台首页',
                'route' => 'index',
            ),
        ));
        
        
    }
}