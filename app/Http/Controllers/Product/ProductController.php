<?php
namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Models\Product;
use App\Http\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Class ProductController extends Controller
{
  public $productModel;
  public $sellerModel;

  public function __construct()
  {
      $this->productModel = new Product;
      $this->sellerModel = new Seller;
  }

  public function add(Request $request)
  {
      $account = session('accountsell');
      if($account == false){
        return redirect()->action('Shopping\ShoppingController@getHomepage');
      }
      $seller = $this->sellerModel->getSellers($account);

      $conf = $request->input('comf');
      $msg = '';
      if($conf == 0){
        return view('product.add', ['msg' => $msg]);
      }

      $params['name'] = $request->input('name');
      if ($params['name'] == null) {
          $msg = "請輸入商品名稱";
          return view('product.add', ['msg' => $msg]);
      }

      $params['price'] = $request->input('price');
      if ($params['price'] == null) {
          $msg = "請輸入價格";
          return view('product.add', ['msg' => $msg]);
      }

      $params['stock'] = $request->input('stock');
      if ($params['stock'] == null) {
          $msg = "請輸入庫存量";
          return view('product.add', ['msg' => $msg]);
      }

      $params['describe'] = $request->input('describe');
      if ($params['describe'] == null) {
          $msg = "請輸入商品描述";
          return view('product.add', ['msg' => $msg]);
      }

      $picture = $request->file('picture');
      if (!is_object($picture)) {
          $msg = "請上傳圖片";
          return view('product.add', ['msg' => $msg]);
      }
      $picture_path_tmp = Storage::putFile("/public/product/".$seller->id, $picture);
      $params['sellerid'] = $seller->id;
      $picture_path_tmp = explode("/", $picture_path_tmp);
      unset($picture_path_tmp[0]);
      $params['picture'] = implode("/", $picture_path_tmp);

      //沒商品的話才給它新增嘛
      $ret = $this->productModel->addProducts($params);
      if (is_array($ret)) {
        $msg = $ret['msg'];
        return view('product.add', ['msg' => $msg]);
      }

      $msg = ($ret == true) ? '新增成功' : '新增失敗';
      return view('product.add', ['msg' => $msg]);
  }

  public function modify(Request $request)
  {
      $account = session('accountsell');
      if($account == false){
        return redirect()->action('Shopping\ShoppingController@getHomepage');
      }
      $seller = $this->sellerModel->getSellers($account);
      $productid = $request->input('productid');
      if ($productid == 0) {
          return redirect()->action('Seller\SellController@getHomepage');
      }
      $conf = $request->input('comf');
      $msg = '';
      $data = $this->productModel->getProducts($productid);
      if (empty($data)) {
          return redirect()->action('Seller\SellController@getHomepage');
      }
      $data->picture = asset('storage/'.$data->picture);

      if ($conf == 0) {
          return view('product.modify', ['data' => $data, 'msg' => $msg]);
      }

      $params['price'] = $request->input('price');
      if ($params['price'] == null) {
          $msg = "請輸入價格";
          return view('product.modify', ['data' => $data, 'msg' => $msg]);
      }

      $params['stock'] = $request->input('stock');
      if ($params['stock'] == null) {
          $msg = "請輸入數量";
          return view('product.modify', ['data' => $data, 'msg' => $msg]);
      }

      $params['describe'] = $request->input('describe');
      if ($params['describe'] == null) {
          $msg = "請輸入商品描述";
          return view('product.modify', ['data' => $data, 'msg' => $msg]);
      }

      $ret = $this->productModel->modifyProducts($productid, $params);
      $msg = ($ret) ? '修改成功' : '修改失敗';

      $data = $this->productModel->getProducts($productid);
      $data->picture = asset('storage/'.$data->picture);
      return view('product.modify', ['data' => $data, 'msg' => $msg]);
  }

  public function listBySeller(Request $request)
  {
      $account = session('accountsell');
      if($account == false){
        return redirect()->action('Shopping\ShoppingController@getHomepage');
      }
      $seller = $this->sellerModel->getSellers($account);
      $products = $this->productModel->getProductsBySellerID($seller->id);
      foreach ($products as $key => $value) {
        $products[$key]->picture = asset('storage/'.$value->picture);
      }
      return view('product.list', ['products' => $products]);
  }

  public function getProduct($pid, Request $request)
  {
      $product = $this->productModel->getProducts($pid);
      $product->picture =  asset('storage/'.$product->picture);
      return view('product.detail', ['product' => $product]);
  }


}
