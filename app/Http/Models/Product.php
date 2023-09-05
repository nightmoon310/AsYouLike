<?php

namespace App\Http\Models;
use Illuminate\Support\Facades\DB;

Class Product
{
  protected function verify($key, $value)
  {
    $ret = ['status' => true, 'msg' => ''];
    if ($key == 'name') {
        if (empty($value)) {
          $ret['status'] = false;
          $ret['msg'] = '商品名稱格式錯誤';
          return $ret;
        }
     }

      if ($key == 'price') {
        if(empty($value)){
          $ret['status'] = false;
          $ret['msg'] = '價格格式錯誤';
          return $ret;
          }
        }

      if ($key == 'stock') {
          if (empty($value)) {
            $ret['status'] = false;
            $ret['msg'] = '庫存量格式錯誤';
            return $ret;
          }
        }

      if ($key == 'describe') {
          if(empty($value)){
              $ret['status'] = false;
              $ret['msg'] = '商品描述格式錯誤';
              return $ret;
          }
      }

      if ($key == 'picture') {
          if(empty($value)){
              $ret['status'] = false;
              $ret['msg'] = '圖片格式錯誤';
              return $ret;
          }
      }

      return $ret;
      //............
  }

  public function getproducts($productid = null)//搜尋條件未定
  {
      if (!empty($productid)) {
          $products = DB::table('product')->where('id', '=', $productid)->first();//搜尋條件未定
      } else {
          $products = DB::table('product')->get()->toArray();
      }
      return $products;
  }

  public function addProducts(array $params)
  {
      foreach ($params as $key => $value) {
        $verify = $this->verify($key, $value);
        if ($verify['status'] == false) {
          // code...
           return $verify;
        }
      }

      $ret = DB::table('product')->insert(
          [
            'name' => $params['name'],
            'sellerid' => $params['sellerid'],
            'price' => $params['price'],
            'stock' => $params['stock'],
            'describe' => $params['describe'],
            'picture' => $params['picture']
          ]
      );
      return $ret;
  }

  public function modifyProducts($productid, array $params)
  {
    // var_dump($productid, $params);
    $ret = DB::table('product')
            ->where('id', $productid)
            ->update($params);
    return $ret;
  }

  public function delProducts($productname)
  {
    $ret = DB::table('product')->where('name', '=', $productname)->delete();
    return $ret;
  }

  public function getProductsBySellerID($sellerid)
  {
    $ret = DB::table('product')->where('sellerid', '=', $sellerid)->get()->toArray();
    return $ret;
  }

  public function searchProduct($key)
  {
    $ret = DB::table('product')
                ->where('name', 'like', "%{$key}%")
                ->get()->toArray();
    return $ret;
  }
}
