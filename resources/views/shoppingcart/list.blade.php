@extends('layout.layout')

@section('content')
<script>
$(document).ready(function(){
  @foreach($data as $key => $val)
  // $("#check-{{$val['id']}}").click(function(){
  //   var check = $("#check-{{$val['id']}}").val();
  //   if (check == "on")
  //   console.log("check-{{$val['id']}} " + check);
  // });
  $("#check-count-{{$val['id']}}").change(function($val){
    var count = $("#check-count-{{$val['id']}}").val();
    var price = $("#check-product-price-{{$val['id']}}").html();
    var stock = parseInt({{$val['stock']}});
    // console.log(stock);
    if ($.isNumeric(count) == false) {
      $("#check-count-{{$val['id']}}").val(1);
    } else {
      if (count > stock) {
        alert("{{$val['product_name']}} 庫存剩下: " + stock);
        $("#check-count-{{$val['id']}}").val(stock);
        $('#check-total-price-{{$val['id']}}').html("$" + stock*price);
      } else {
        $('#check-total-price-{{$val['id']}}').html("$" + count*price);
      }
    }
  });
  @endforeach

});
</script>
    <br>
    <div class="container">
        <!-- 下單表單 -->
          <fieldset>
          <legend>購物車</legend>
          @if(!empty($msg))
            <span class="text-danger">{{$msg}}</span>
          @endif
          @if(!empty($data))
          <form action="{{action('Order\OrderController@checkOrderFromShoppingCarts')}}" method="POST">
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
                    <td></td>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $key => $val)
                <tr class="table">
                  <td scope="row">
                    @if($val['stock'] == 0)
                    <input class="form-check-input" type="checkbox" id="check-{{$val['id']}}" name="check[{{$val['id']}}]" disabled>
                    @else
                    <input class="form-check-input" type="checkbox" id="check-{{$val['id']}}" name="check[{{$val['id']}}]">
                    @endif
                    <input type="hidden" name="check-productid[{{$val['id']}}]" value="{{$val['productid']}}">
                  </td>
                  <td width="50%"><a target="_blank" href="/p/{{$val['productid']}}/?{{$val['product_name']}}">{{$val['product_name']}}</td>
                  <td>$<span id="check-product-price-{{$val['id']}}">{{$val['product_price']}}</span></td>
                  <td>
                    @if($val['stock'] == 0)
                    <input class="form-control-sm" name="check-count[{{$val['id']}}]" id="check-count-{{$val['id']}}" type="text" placeholder="暫無存貨" disabled>
                    @else
                    <input class="form-control-sm" name="check-count[{{$val['id']}}]" id="check-count-{{$val['id']}}" type="text" value="{{$val['count']}}">
                    @endif
                  </td>
                  <td class="text-danger" id="check-total-price-{{$val['id']}}">${{$val['total_price']}}</td>
                  <td><img src="{{$val['product_picture']}}" width="100px"></td>
                  <td><a href="/shoppingcart/delete?id={{$val['id']}}"><ion-icon name="close-outline" style="width: 32px;height: 32px"></ion-icon></td>
                </tr>
                @endforeach
                <tr class="table-light">
                  <td colspan="7" align="right"><input type="hidden" name="comf" value="1"><button type="submit" class="btn btn-primary">購買</button></td>
                </tr>
              </tbody>
            </table>
          </form>
          @endif
          </fieldset>
    </div>
@endsection
