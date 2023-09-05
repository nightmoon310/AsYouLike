<?php

namespace App\Http\Models;
use Illuminate\Support\Facades\DB;

class Shoppingcart{
  protected function verify($key, $value)
  {
    $ret = ['status' => true, 'msg' => ''];
    if ($key == 'productid') {
        if (empty($value)) {
          $ret['status'] = false;
          $ret['msg'] = '此商品不存在';
          return $ret;
        }
     }

      if ($key == 'userid') {
          if(empty($value)){
              $ret['status'] = false;
              $ret['msg'] = '請先登入';
              return $ret;
          }
      }
      return $ret;
}

  public function getShoppingcarts($userID = null)
  {
      if (!empty($userID)) {
          $users = DB::table('shoppingcart')->where('userid', '=', $userID)->get()->toArray();
      } else {
          $users = DB::table('shoopingcart')->get()->toArray();
      }
      return $users;
  }

  public function addShoppingcarts(array $params){
      foreach ($params as $key => $value) {
        $verify = $this->verify($key, $value);
        if ($verify['status'] == false) {
          // code...
           return $verify;
        }
      }

      $ret = DB::table('shoppingcart')->updateOrInsert(
          [ 'userid' => $params['userid'], 'productid' => $params['productid'] ],
          ['count' => $params['count']]
      );
      return $ret;
  }
  public function delShoppingcarts($id, $userid)
  {
    $ret = DB::table('shoppingcart')
      ->where('userid', $userid)
      ->where('id', $id)
      ->delete();
    return $ret;
  }
}
