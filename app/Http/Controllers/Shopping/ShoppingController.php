<?php
namespace App\Http\Controllers\Shopping;

use App\Http\Controllers\Controller;
use App\Http\Models\User;
use App\Http\Models\Product;
use Illuminate\Http\Request;

Class ShoppingController extends Controller
{
    public $userModel;
    public $productModel;

    public function __construct()
    {
        $this->userModel = new User;
        $this->productModel = new Product;
    }

    public function getHomePage(Request $request)
    {
        $search = $request->input('search');
        //model
        $products = (!empty($search))
          ? $this->productModel->searchProduct($search)
          : $this->productModel->getproducts();

        foreach ($products as $key => $value) {
          $products[$key]->picture = asset('storage/'.$value->picture);
        }
        return view('shopping.homepage', ['products' => $products, 'search' => $search]);
    }

    public function changeacc(Request $request)
    {
      $account = session('accountsell');
      if($account == false){
        return redirect()->action('Shopping\ShoppingController@getHomepage');
      }

      //登入 存成買家session
      session(['accountbuy' => $account]);
      session()->forget('accountsell');

      return redirect()->action('Shopping\ShoppingController@getHomepage');
    }

    public function login(Request $request)
    {
      if(!empty(session('accountbuy'))){
        return redirect()->action('Shopping\ShoppingController@getHomepage');
      }

      if(!empty(session('accountsell'))){
        return redirect()->action('Seller\SellController@getHomepage');
      }

      $conf = $request->input('comf');
      $msg = '';
      if ($conf == 0) {
          return view('shopping.login', ['msg' => $msg]);
      }

      $params['account'] = $request->input('account');
      if ($params['account'] == null) {
          $msg = "請輸入帳號";
          return view('shopping.login', ['msg' => $msg]);
      }

      $params['password'] = $request->input('password');
      if ($params['password'] == null) {
          $msg = "請輸入密碼";
          return view('shopping.login', ['msg' => $msg]);
      }

      $new = $this->userModel->getUsers($params['account']);
      if (empty($new)) {
          $msg = '你的帳號或密碼不正確，請稍後再試';
          return view('shopping.login',['msg' => $msg]);
      }

      if ($params['password'] !== $new->password) {
          $msg = '你的帳號或密碼不正確，請稍後再試';
          return view('shopping.login',['msg' => $msg]);
      }
      // 將帳號寫入session，方便驗證使用者身份
      session(['accountbuy' => $params['account']]);
      return redirect()->action('Shopping\ShoppingController@getHomepage');
    }

    public function add(Request $request)
    {
      $account = session('accountbuy');
      if(!empty($account)){
        return redirect()->action('Shopping\ShoppingController@getHomepage');
      }

      $conf = $request->input('comf');
      $msg = '';
      if($conf == 0){
        return view('shopping.add', ['msg' => $msg]);
      }

      $params['name'] = $request->input('name');
      if ($params['name'] == null) {
          $msg = "請輸入姓名";
          return view('shopping.add', ['msg' => $msg]);
      }

      $params['tel'] = $request->input('tel');
      if ($params['tel'] == null) {
          $msg = "請輸入電話";
          return view('shopping.add', ['msg' => $msg]);
      }

      $params['email'] = $request->input('email');
      if ($params['email'] == null) {
          $msg = "請輸入信箱";
          return view('shopping.add', ['msg' => $msg]);
      }

      $params['birth'] = $request->input('birth');
      if ($params['birth'] == null) {
          $msg = "請輸入生日";
          return view('shopping.add', ['msg' => $msg]);
      }

      $params['address'] = $request->input('address');

      $params['account'] = $request->input('account');
      if ($params['account'] == null) {
          $msg = "請輸入帳號";
          return view('shopping.add', ['msg' => $msg]);
      }

      $params['password'] = $request->input('password');
      $request->input('repassword');
      if ($params['password'] == null) {
          $msg = "請輸入密碼";
          return view('shopping.add', ['msg' => $msg]);
      }
      if ($params['password'] !== $request->input('repassword')) {
          $msg = "密碼確認與您輸入的密碼不符合";
          return view('shopping.add', ['msg' => $msg]);
      }
      //@todo 判斷帳號是否存在
      $new = $this->userModel->getUsers($params['account']);
      if (!empty($new)) {
        $msg = "此帳號已存在";
        return view('shopping.add',['msg' => $msg]);
      }

      //沒帳號的話才給它新增
      $ret = $this->userModel->addUsers($params);
      if (is_array($ret)) {
        $msg = $ret['msg'];
        return view('shopping.add', ['msg' => $msg]);
      }

      $msg = ($ret == true) ? '註冊成功' : '註冊失敗';
      return view('shopping.add', ['msg' => $msg]);
    }

    public function modify(Request $request)
    {
        $account = session('accountbuy');
        if($account == false){
          return redirect()->action('Shopping\ShoppingController@getHomepage');
        }

        $conf = $request->input('comf');
        $msg = '';
        $data = $this->userModel->getUsers($account);
        if ($conf == 0) {
            return view('shopping.modify', ['data' => $data, 'msg' => $msg]);
        }

        $params['name'] = $request->input('name');
        if ($params['name'] == null) {
            $msg = "請輸入姓名";
            return view('shopping.modify', ['data' => $data, 'msg' => $msg]);
        }

        if (!empty($request->input('password'))) {
            $params['password'] = $request->input('password');
        };


        $params['tel'] = $request->input('tel');
        if ($params['tel'] == null) {
            $msg = "請輸入電話";
            return view('shopping.modify', ['data' => $data, 'msg' => $msg]);
        }

        $params['address'] = $request->input('address');
        $params['email'] = $request->input('email');
        if ($params['email'] == null) {
            $msg = "請輸入email";
            return view('shopping.modify', ['data' => $data, 'msg' => $msg]);
        }

        $ret = $this->userModel->modifyUsers($account, $params);
        if (is_array($ret)) {
          $msg = $ret['msg'];
          return view('shopping.modify', ['data' => $data, 'msg' => $msg]);
        }

        $msg = ($ret == true) ? '修改成功' : '修改失敗';

        $data = $this->userModel->getUsers($account);
        return view('shopping.modify', ['data' => $data, 'msg' => $msg]);
    }

    public function logout(Request $request)
    {
        $account = session('accountbuy');
        if($account == false){
           return redirect()->action('Shopping\ShoppingController@getHomepage');
        }
        session()->forget('accountbuy');
        return redirect()->action('Shopping\ShoppingController@getHomepage');
    }
}
