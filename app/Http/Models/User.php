<?php

namespace App\Http\Models;
use Illuminate\Support\Facades\DB;

Class User
{
    protected function verify($key, $value)
    {
      $ret = ['status' => true, 'msg' => ''];
      if ($key == 'name') {
          $name_len = strlen($value);
          if ($name_len < 3 || $name_len > 18) {
            $ret['status'] = false;
            $ret['msg'] = '暱稱格式錯誤';
            return $ret;
          }
       }

        if ($key == 'tel') {
            if(!preg_match("/^09\d{8}$/", $value)){
                $ret['status'] = false;
                $ret['msg'] = '手機格式錯誤';
                return $ret;
            }
        }

        if ($key == 'birth') {
          $is_date = strtotime($value) ? strtotime($value) : false;
          if($is_date === false){         //请注意三个等号
            $ret['msg'] = '日期格式錯誤';
            return $ret;
            }
          }

        if ($key == 'email') {
            if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
              $ret['status'] = false;
              $ret['msg'] = '信箱格式錯誤';
              return $ret;
            }
          }

        if ($key == 'account') {
            if(!preg_match("/^[A-Za-z0-9]+$/",$value)){
                $ret['status'] = false;
                $ret['msg'] = '帳號格式錯誤';
                return $ret;
            }
        }

        if ($key == 'password') {
            if(!preg_match("/^[A-Za-z0-9]+$/",$value)){
                $ret['status'] = false;
                $ret['msg'] = '密碼格式錯誤';
                return $ret;
            }
        }

        return $ret;
        //............
    }

    public function getUsers($userAccount = null)
    {
        if (!empty($userAccount)) {
            $users = DB::table('user')->where('account', '=', $userAccount)->first();
        } else {
            $users = DB::table('user')->get()->toArray();
        }
        return $users;
    }

    public function getUserByID($userid)
    {
        $user = DB::table('user')->where('id', '=', $userid)->first();
        return $user;
    }

    public function addUsers(array $params)
    {
        foreach ($params as $key => $value) {
          $verify = $this->verify($key, $value);
          if ($verify['status'] == false) {
            // code...
             return $verify;
          }
        }

        $ret = DB::table('user')->insert(
            [
              'name' => $params['name'],
              'tel' => $params['tel'],
              'email' => $params['email'],
              'birth' => $params['birth'],
              'address' => $params['address'],
              'account' => $params['account'],
              'password' => $params['password']
            ]
        );
        return $ret;
    }

    public function modifyUsers($userAccount, array $params)
    {
      foreach ($params as $key => $value) {
        $verify = $this->verify($key, $value);
        if ($verify['status'] == false) {
          // code...
           return $verify;
        }
      }
      // var_dump($userAccount, $params);
      $ret = DB::table('user')
              ->where('account', $userAccount)
              ->update($params);
      return $ret;
    }

    public function delUsers($userAccount)
    {
      $ret = DB::table('user')->where('account', '=', $userAccount)->delete();
      return $ret;
    }
}
