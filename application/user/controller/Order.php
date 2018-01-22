<?php
/**
 * Created by PhpStorm.
 * User: 1006a
 * Date: 2018/1/6
 * Time: 11:26
 */

namespace app\user\controller;

use think\Controller;
use think\Db;
class Order extends Controller
{
    //权限角色管理
    public function role_manager()
    {
        $role = Db::table('ks_role')->select();
        $this->assign('role',$role);
        return $this->fetch();
    }


    //添加新角色
    public function add_role()
    {
        return $this->fetch();
    }

    //编辑角色权限
    public function role_access()
    {
        $access = Db::name('access')->select();
        $sons_rule = $this->getSubTree($access);
        var_dump($sons_rule);die;
        $main_rule =  Db::name('access')->where('pid=0')->select();
        $this->assign('access',$access);
        $this->display();
    }

    /**
     * 获取子孙树
     * @param   array        $data   待分类的数据
     * @param   int/string   $id     要找的子节点id
     * @param   int          $lev    节点等级
     */
    function getSubTree($data , $id = 0 , $lev = 0) {
        static $son = array();

        foreach($data as $key => $value) {
            if($value['pid'] == $id) {
                $value['lev'] = $lev;
                $son[] = $value;
               $this->getSubTree($data , $value['id'] , $lev+1);
            }
        }

        return $son;
    }


    //权限管理
    public function access_manager()
    {
        $access = Db::table('ks_access')->select();
        $this->assign('access',$access);
        return $this->fetch();
    }

    //添加权限
    public function access_add()
    {
        $res = Db::name('access')->select();
        $access = $this->getSubTree($res);
        $this->assign('access',$access);
        return $this->fetch();
    }


    //执行添加权限
    public function do_access()
    {
          if(IS_POST)
          {
              $rules =  input('post.access_rules');
              $access_name = input('post.access_name');
              $pid = input('post.pid');
              if($access_name && $rules)
              {
                  $data['title'] = $access_name;
                  $data['rules'] = $rules;
                  $data['status'] = 0;
                  $data['pid'] = $pid;
                  $data['update_time'] = time();
                  $data['create_time'] = time();
                  $res = Db::name('access')->where('rules <>'.$rules)->insert($data);
                  if($res)
                  {
                      $this->success('添加成功');
                  }else{
                      $this->error('该权限已存在');
                  }
              }else{
                  $this->error('输入为空');
              }
          }
    }

}