<?php

namespace App\Http\Models;
use Illuminate\Support\Facades\DB;

Class Order
{
  public function getOrderByUserID($userid)
  {
    $ret = DB::table('order')->where('userid', '=', $userid)->get()->toArray();
    return $ret;
  }

  public function getOrderByProductID($productid)
  {
    $ret = DB::table('order')->where('productid', '=', $productid)->get()->toArray();
    return $ret;
  }

  public function getOrderByGroupID($groupid)
  {
    $ret = DB::table('order')->where('groupid', '=', $groupid)->get()->toArray();
    return $ret;
  }

  public function deleteByGroupID($groupid)
  {
    $ret = DB::table('order')->where('groupid', '=', $groupid)->delete();
    return $ret;
  }

  public function add($params)
  {
    $ret = DB::table('order')->insert(
        [
          'groupid' => $params['groupid'],
          'userid' => $params['userid'],
          'productid' => $params['productid'],
          'productname' => $params['productname'],
          'productprice' => $params['productprice'],
          'count' => $params['count'],
          'totalprice' => $params['totalprice'],
          'address' => $params['address'],
        ]
    );
    return $ret;
  }
}
