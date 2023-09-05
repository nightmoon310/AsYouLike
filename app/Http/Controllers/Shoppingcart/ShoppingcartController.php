<?php
namespace App\Http\Controllers\Shoppingcart;

use App\Http\Controllers\Controller;
use App\Http\Models\Shoppingcart;
use App\Http\Models\User;
use App\Http\Models\Product;
use Illuminate\Http\Request;

class ShoppingcartController extends Controller
{
  public $shoppingcartModel;
  public $userModel;
  public $productModel;

  public function __construct()
  {
      $this->shoppingcartModel = new Shoppingcart;
      $this->userModel = new User;
      $this->productModel = new Product;
  }

  public function getShoppingcart(Request $request)
  {
    $account = session('accountbuy');
    if($account == false){
      return redirect()->action('Shopping\ShoppingController@getHomepage');
    }
    $data = [];
    $user = $this->userModel->getUsers($account);
    $shoppingcart = $this->shoppingcartModel->getShoppingcarts($user->id);
    // empty
    if(empty($shoppingcart)) {
      return view('shoppingcart.list', ['data' => $data, 'msg' => '購物車是空的']);
    }

    foreach ($shoppingcart as $key => $cart) {
      $product = $this->productModel->getproducts($cart->productid);
      $data[] = [
        'id' => $cart->id,
        'productid' => $cart->productid,
        'count' => $cart->count,
        'product_name' => $product->name,
        'product_price' => $product->price,
        'total_price' => $product->price*$cart->count,
        'product_picture' => asset('storage/'.$product->picture),
        'stock' => $product->stock,
        'sellerid' => $product->sellerid
      ];
    }

    $msg = $request->input('msg');
    return view('shoppingcart.list', ['data' => $data, 'msg' => $msg]);
  }

  public function add(Request $request)
  {
    $account = session('accountbuy');
    if($account == false){
      return redirect()->action('Shopping\ShoppingController@login');
    }
    $productid = $request->input('productid');
    //檢查有無此商品
    $product = $this->productModel->getProducts($productid);
    $product->picture =  asset('storage/'.$product->picture);
    if (empty($product)) {
        return redirect()->action('Shopping\ShoppingController@getHomepage');
    }

    $count = $request->input('count');
    if ($count == null || !is_numeric($count)) {
        $msg = "請輸入數量";
        return view('product.detail', ['product' => $product, 'msg' => $msg]);
    }
    $user = $this->userModel->getUsers($account);

    // var_dump($user->id, $productid, $product->sellerid);
    $params = [
      'productid' => $productid,
      'userid' => $user->id,
      'count' => $count
    ];

    //新增或調整數量
    $ret = $this->shoppingcartModel->addShoppingcarts($params);
    if (is_array($ret)) {
      $msg = $ret['msg'];
      return view('product.detail', ['product' => $product, 'msg' => $msg]);
    }

    $msg = ($ret == true) ? '加入購物車成功' : '加入購物車失敗';
    return view('product.detail', ['product' => $product, 'msg' => $msg]);
  }

  public function delete(Request $request)
  {
    $account = session('accountbuy');
    if($account == false){
      return redirect()->action('Shopping\ShoppingController@login');
    }
    $user = $this->userModel->getUsers($account);
    $id = $request->input('id');

    $ret = $this->shoppingcartModel->delShoppingcarts($id, $user->id);
    return redirect()->action('Shoppingcart\ShoppingcartController@getShoppingcart');
  }
}
