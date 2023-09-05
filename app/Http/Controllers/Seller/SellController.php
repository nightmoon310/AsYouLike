<?php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Models\Seller;
use Illuminate\Http\Request;

Class SellController extends Controller
{
    public $sellerModel;

    public function __construct()
    {
        $this->sellerModel = new Seller;
    }

    public function changeacc(Request $request)
    {
      $account = session('accountbuy');
      if($account == false){
        return redirect()->action('Shopping\ShoppingController@getHomepage');
      }
      $msg = '';
      //model
      $sellers = $this->sellerModel->getSellers($account);
      //controller
      if(empty($sellers)){
        //註冊
        $params = [
          'account' => $account,
          'storename' => $account."的賣場",
          'describe' => ""
        ];

        $ret = $this->sellerModel->addSellers($params);
        $msg = ($ret == true) ? '註冊成功' : '註冊失敗';
      }
      //登入 存成賣家session
      session(['accountsell' => $account]);
      session()->forget('accountbuy');

      return redirect()->action('Seller\SellController@getHomepage');
    }

    public function logout(Request $request)
    {
        $account = session('accountsell');
        if($account == false){
           return redirect()->action('Shopping\ShoppingController@getHomepage');
        }
        session()->forget('accountsell');
        return redirect()->action('Shopping\ShoppingController@getHomepage');
    }

    public function getHomePage(Request $request)
    {
      $account = session('accountsell');
      if($account == false){
        return redirect()->action('Shopping\ShoppingController@getHomepage');
      }

      return redirect()->action('Product\ProductController@listBySeller');
    }



    public function modify(Request $request)
    {
        $account = session('accountsell');
        if($account == false){
          return redirect()->action('Shopping\ShoppingController@getHomepage');
        }

        $conf = $request->input('comf');
        $msg = '';
        $data = $this->sellerModel->getSellers($account);
        if ($conf == 0) {
            return view('sell.modify', ['data' => $data, 'msg' => $msg]);
        }

        $params['storename'] = $request->input('storename');
        if ($params['storename'] == null) {
            $msg = "請輸入賣場名稱";
            return view('sell.modify', ['data' => $data, 'msg' => $msg]);
        }

        $params['describe'] = $request->input('describe');
        if ($params['describe'] == null) {
            $msg = "請輸入賣場描述";
            return view('sell.modify', ['data' => $data, 'msg' => $msg]);
        }

        $ret = $this->sellerModel->modifySellers($account, $params);
        $msg = ($ret) ? '修改成功' : '修改失敗';


        $data = $this->sellerModel->getSellers($account);
        return view('sell.modify', ['data' => $data, 'msg' => $msg]);
    }
}
