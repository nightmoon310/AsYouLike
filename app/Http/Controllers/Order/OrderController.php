<?php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Models\Product;
use App\Http\Models\Order;
use App\Http\Models\Shoppingcart;
use App\Http\Models\Seller;
use App\Http\Models\User;
use App\Helper\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Class OrderController extends Controller
{
  public $shoppingcartModel;
  public $userModel;
  public $productModel;
  public $orderModel;
  public $sellerModel;

  public function __construct()
  {
      $this->shoppingcartModel = new Shoppingcart;
      $this->userModel = new User;
      $this->productModel = new Product;
      $this->orderModel = new Order;
      $this->sellerModel = new Seller;
  }

  public function checkOrderFromShoppingCarts(Request $request)
  {
    $account = session('accountbuy');
    if($account == false){
      return redirect()->action('Shopping\ShoppingController@getHomepage');
    }
    $check = $request->input('check');
    if(empty($check)) {
      return redirect()->action('Shoppingcart\ShoppingcartController@getShoppingcart', ['msg' => '請勾選要購買的商品']);
    }
    $check_count = $request->input('check-count');
    $check_productid = $request->input('check-productid');
    $orders = [];
    $total_price = 0;
    foreach ($check as $key => $value) {
      //檢查庫存
      $product = $this->productModel->getproducts($check_productid[$key]);
      if($check_count[$key] > $product->stock) {
        return redirect()->action('Shoppingcart\ShoppingcartController@getShoppingcart', ['msg' => "{$product->name}，暫無存貨。庫存量：{$product->stock}"]);
      }
      $orders[] = [
        'cartid' => $key,
        'productid' => $check_productid[$key],
        'product_name' => $product->name,
        'count' => $check_count[$key],
        'price' => $product->price,
        'total_price' => $check_count[$key] * $product->price,
        'product_picture' => asset('storage/'.$product->picture)
      ];
      $total_price += $check_count[$key] * $product->price;
    }
    $user = $this->userModel->getUsers($account);
    return view('order.check', ['orders' => $orders, 'address' => $user->address, 'total_price' => $total_price]);
  }

  public function checkOrder(Request $request)
  {
    $account = session('accountbuy');
    if($account == false){
      return redirect()->action('Shopping\ShoppingController@getHomepage');
    }

    $user = $this->userModel->getUsers($account);
    $productid = $request->input('productid');
    $count = $request->input('count');
    $product = $this->productModel->getproducts($productid);
    $total_price = 0;
    $orders[] = [
      'cartid' => Null,
      'productid' => $productid,
      'product_name' => $product->name,
      'count' => $count,
      'price' => $product->price,
      'total_price' => $count * $product->price,
      'product_picture' => asset('storage/'.$product->picture)
    ];
    $total_price += $count * $product->price;
    return view('order.check', ['orders' => $orders, 'address' => $user->address, 'total_price' => $total_price]);
  }

  public function addFromShoppingCarts(Request $request)
  {
    $account = session('accountbuy');
    if($account == false){
      return redirect()->action('Shopping\ShoppingController@getHomepage');
    }
    $user = $this->userModel->getUsers($account);
    $orders = $request->input('order');
    $address = $request->input('address');
    $groupid = Helper::randomString(10);

    foreach ($orders as $key => $order) {
      $product = $this->productModel->getproducts($order['productid']);
      $order = [
        'groupid' => $groupid,
        'userid' => $user->id,
        'productid' => $product->id,
        'productname' => $product->name,
        'productprice' => $product->price,
        'count' => $order['count'],
        'totalprice' => $product->price*$order['count'],
        'address' => $address
      ];
      $this->orderModel->add($order);
    }

    //確認寫入狀況
    $db_order = $this->orderModel->getOrderByGroupID($groupid);
    if (count($db_order) == count($orders)) {
      //訂單正常 調整庫存數量
      foreach($orders as $order) {
        $product = $this->productModel->getproducts($order['productid']);
        $new_stock = $product->stock - $order['count'];
        $this->productModel->modifyProducts($order['productid'], ['stock' => $new_stock]);
        //移除購物車資料
        if (!empty($order['cartid'])) {
            $this->shoppingcartModel->delShoppingcarts($order['cartid'], $user->id);
        }
      }
      //跳轉到訂單查詢頁面
      return redirect()->action('Order\OrderController@getUserOrders');
    }
    //存入資料不符刪除訂單並回傳錯誤訊息
    $db_order = $this->orderModel->deleteByGroupID($groupid);
    return view('shoppingcart.list', ['data' => $data, 'msg' => '下訂發生異常，請稍後再試']);
  }

  public function getUserOrders(Request $request)
  {
    $account = session('accountbuy');
    if($account == false){
      return redirect()->action('Shopping\ShoppingController@getHomepage');
    }
    $user = $this->userModel->getUsers($account);
    $orders = $this->orderModel->getOrderByUserID($user->id);
    $data = [];
    if (empty($orders)) {
      return view('order.userlist', ['data' => $data, 'msg' => '查無訂單，立即去購物吧！！']);
    }

    //組資料
    foreach ($orders as $order) {
      $data[$order->groupid][] = [
        'groupid' => $order->groupid,
        'count' => $order->count,
        'productid' => $order->productid,
        'productname' => $order->productname,
        'totalprice' => $order->totalprice,
        'productprice' => $order->productprice,
        'address' => $order->address
      ];
    }

    //算group 總金額
    $total_price_group = [];
    foreach ($data as $groupid => $group) {
      $group_total_price = 0;
      foreach ($group as $order) {
        $group_total_price += $order['totalprice'];
      }
      $total_price_group[$groupid] = $group_total_price;
    }
    return view('order.userlist', ['data' => $data, 'total_price_group' => $total_price_group]);
  }

  public function getSellerOrders(Request $request)
  {
    $account = session('accountsell');
    if($account == false){
      return redirect()->action('Shopping\ShoppingController@getHomepage');
    }
    $seller = $this->sellerModel->getSellers($account);
    $products = $this->productModel->getProductsBySellerID($seller->id);
    $data = [];
    foreach($products as $product) {
      $orders = $this->orderModel->getOrderByProductID($product->id);
      foreach ($orders as $order) {
        $user = $this->userModel->getUserByID($order->userid);
        $data[$order->groupid][] = [
          'groupid' => $order->groupid,
          'count' => $order->count,
          'productid' => $order->productid,
          'productname' => $order->productname,
          'totalprice' => $order->totalprice,
          'productprice' => $order->productprice,
          'address' => $order->address,
          'username' => $user->name
        ];
      }
    }

    if (empty($data)) {
      return view('order.sellerlist', ['data' => $data, 'msg' => '尚無訂單，趕快上架商品吸引顧客吧！！']);
    }

    //算group 總金額
    $total_price_group = [];
    foreach ($data as $groupid => $group) {
      $group_total_price = 0;
      foreach ($group as $order) {
        $group_total_price += $order['totalprice'];
      }
      $total_price_group[$groupid] = $group_total_price;
    }
    return view('order.sellerlist', ['data' => $data, 'total_price_group' => $total_price_group]);
  }
}
