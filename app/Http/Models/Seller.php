<?php

namespace App\Http\Models;
use Illuminate\Support\Facades\DB;

class Seller
{
  public function getSellers($sellerAccount = null)
  {
      if (!empty($sellerAccount)) {
          $sellers = DB::table('seller')->where('account', '=', $sellerAccount)->first();
      } else {
          $sellers = DB::table('seller')->get()->toArray();
      }
      return $sellers;
  }

  public function addSellers(array $params)
  {
      // foreach ($params as $key => $value) {
      //   $verify = $this->verify($key, $value);
      //   if ($verify['status'] == false) {
      //     // code...
      //      return $verify;
      //   }
      // }

      $ret = DB::table('seller')->insert(
          [
            'account' => $params['account'],
            'storename' => $params['storename'],
            'describe' => $params['describe']
          ]
      );
      return $ret;
  }

  public function modifySellers($sellerAccount, array $params)
  {
    // var_dump($sellerAccount, $params);
    $ret = DB::table('seller')
            ->where('account', $sellerAccount)
            ->update($params);
    return $ret;
  }

  public function delSellers($sellerAccount)
  {
    $ret = DB::table('seller')->where('account', '=', $sellerAccount)->delete();
    return $ret;
  }
}
