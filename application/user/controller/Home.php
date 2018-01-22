<?php
/**
 * Created by PhpStorm.
 * User: 1006a
 * Date: 2018/1/6
 * Time: 13:44
 */

namespace app\user\controller;


use think\Controller;
use think\Db;
use think\Request;
use Rbac\Rbac;
class Home extends Controller
{
  public function _initialize()
  {
//      if(!session('user'))
//      {
//            $this->redirect('/index');
//            die;
//      }
      $rbac = new Rbac();
      $request = Request::instance();
     $rule_name=$request->module().'/'. $request->controller().'/'.$request->action();
//
//
      $user_id = session('user')['id'];
      $user_id =1;
//
      $result = $rbac->checkRules($rule_name,$user_id);
//
//      if(!$result){
//          $this->error('您没有权限访问');
//      }

  }

}