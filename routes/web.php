<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|-----------------------------------------------------------Us---------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/ping', function()
{
    return date('Y-m-d H:i:s');
});

Route::get('/tmp', function()
{
    return view('tmp');
});

Route::group(['prefix' => 'seller', 'namespace' => 'Seller'], function () {
    Route::match(['get', 'post'], '/homepage', 'SellController@getHomepage');
    Route::match(['get', 'post'], '/modify', 'SellController@modify');
    Route::match(['get', 'post'], '/change', 'SellController@changeacc');
    Route::match(['get', 'post'], '/logout', 'SellController@logout');
});

Route::group(['prefix' => 'product', 'namespace' => 'Product'], function () {
    Route::match(['get', 'post'], '/add', 'ProductController@add');
    Route::match(['get', 'post'], '/modify', 'ProductController@modify');
    Route::match(['get', 'post'], '/list', 'ProductController@listBySeller');
});

Route::group(['prefix' => 'shoppingcart', 'namespace' => 'Shoppingcart'], function (){
    Route::match(['get', 'post'], '/cart', 'ShoppingcartController@getShoppingcart');
    Route::match(['get', 'post'], '/add', 'ShoppingcartController@add');
    Route::get('/delete', 'ShoppingcartController@delete');
});

Route::group(['prefix' => 'order', 'namespace' => 'Order'], function (){
  //下訂單功能
  Route::post('/checkout', 'OrderController@addFromShoppingCarts');
  //檢查購物車訂單
  Route::post('/check', 'OrderController@checkOrderFromShoppingCarts');
  //檢查直接購買訂單
  Route::post('/order', 'OrderController@checkOrder');
  //使用者查看訂單
  Route::get('/userOrders', 'OrderController@getUserOrders');
  //賣家查看訂單
  Route::get('/sellerOrders', 'OrderController@getSellerOrders');
});

Route::get('/', 'Shopping\ShoppingController@getHomepage');
Route::get('/p/{pid}/', 'Product\ProductController@getProduct');

Route::group(['prefix' => 'shopping', 'namespace' => 'Shopping'], function () {
    Route::match(['get', 'post'], '/modifyUser', 'ShoppingController@modify');
    Route::match(['get', 'post'], '/addUser', 'ShoppingController@add');
    Route::match(['get', 'post'], '/login', 'ShoppingController@login');
    Route::match(['get', 'post'], '/logout', 'ShoppingController@logout');
    Route::match(['get', 'post'], '/change', 'ShoppingController@changeacc');
});
