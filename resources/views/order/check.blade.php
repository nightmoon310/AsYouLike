@extends('layout.layout')

@section('content')
    <br>
    <div class="container">
        <!-- 下單表單 -->
          <fieldset>
          <legend>訂單確認</legend>
          @if(!empty($msg))
            <span class="text-danger">{{$msg}}</span>
          @endif
          @if(!empty($orders))
          <form action="{{action('Order\OrderController@addFromShoppingCarts')}}" method="POST">
            @csrf
            <table class="table table-hover">
              <thead>
                <tr class="table-active">
                    <th scope="row">  </th>
                    <td>商品名稱</td>
                    <td>商品價格</td>
                    <td>購買數量</td>
                    <td>總計</td>
                    <td>圖片</td>
                </tr>
              </thead>
              <tbody>
                @foreach($orders as $key => $val)
                <tr class="table">
                  <td scope="row">{{$key+1}}</td>
                  <td width="50%"><a target="_blank" href="/p/{{$val['productid']}}/?{{$val['product_name']}}">{{$val['product_name']}}</td>
                  <td>${{$val['price']}}</td>
                  <td>{{$val['count']}}</td>
                  <td class="text-danger">${{$val['total_price']}}</td>
                  <td><img src="{{$val['product_picture']}}" width="100px"></td>
                  <input type="hidden" name="order[{{$key}}][cartid]" value="{{$val['cartid']}}">
                  <input type="hidden" name="order[{{$key}}][productid]" value="{{$val['productid']}}">
                  <input type="hidden" name="order[{{$key}}][count]" value="{{$val['count']}}">
                </tr>
                @endforeach
                <tr class="table-light">
                  <td colspan="6">
                    <div class="mb-3 row">
                      <label for="inputAddress" class="col-sm-2 col-form-label">寄送地址：</label>
                      <div class="col-sm-10">
                        <input type="text" name="address" class="form-control" value="{{$address}}">
                      </div>
                    </div>
                  </td>
                </tr>
                <tr class="table-light">
                  <td colspan="5" align="right">總金額：<span class="text-danger">${{$total_price}}</span></td>
                  <td align="right">
                    <button type="submit" class="btn btn-primary">下訂單</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </form>
          @endif
          </fieldset>
    </div>
@endsection
