@extends('layout.layout')
@section('content')
<script>
$(document).ready(function(){
  $("#addShoppingcart").click(function(){
    window.location = "/shoppingcart/add?productid={{$product->id}}&count=" + $("#count").val();
  });
    $("#count").change(function(){
      var count = $("#count").val();
      var stock = parseInt($("#stock").html());
      if ($.isNumeric(count) == false) {
        $("#count").val(1);
      }
      // console.log(count, stock);
      if (count > stock) {
        alert("庫存剩下: " + stock);
        $("#count").val(stock);
      }
    });

});
</script>
    <br>
    <div class="container">
        <!-- Content here -->

        <div class="row">
          <div class="col-lg-6">
            <img src="{{$product->picture}}" width="400px">
          </div>
          <div class="col-lg-4">
            <form action="{{action('Order\OrderController@checkOrder')}}" method="POST">
                @csrf
                <fieldset>
                  <hr><legend>{{$product->name}}</legend>
                    <div class="form-group">
                      <div class="alert alert-dismissible alert-secondary">
                        <h1 class="text-danger">${{$product->price}}</h1>
                      </div>
                    </div>
                    <div class="form-group">
                        <label for="stock" class="form-label mt-4">數量</label>
                        <div class="row">
                          <div class="col-sm-6">
                            <input type="text" id="count" name="count" class="form-control" value="1">
                          </div>
                          <div class="col-sm-4 mt-2">
                            @if($product->stock == 0)
                              <small class="text-danger">暫無存貨</small>
                            @else
                              <small class="text-muted">還剩<span id="stock">{{$product->stock}}</span>件</small>
                            @endif
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label mt-4"></label>
                        <input type="hidden" name="productid" value="{{$product->id}}">
                        @if($product->stock == 0)
                          <button type="button" class="btn btn-outline-danger" disabled><ion-icon name="basket-outline" style="width: 20px;height: 20px"></ion-icon>加入購物車</button>
                          <button type="button" class="btn btn-danger" disabled>直接購買</button>
                        @else
                          <button id="addShoppingcart" type="button" class="btn btn-outline-danger"><ion-icon name="basket-outline" style="width: 20px;height: 20px"></ion-icon>加入購物車</button>
                          <button type="submit" class="btn btn-danger">直接購買</button>
                        @endif
                    </div>
                </fieldset>
            </form>
          </div>
        </div>
        <br>
        @if(isset($msg))
          <h3 class='text-warning'>{{$msg}}</h1>
        @endif
        <br><hr>
        <div class="row">
        <div class="card border-dark mb-3 col-lg-10">
          <div class="card-header">詳細資料</div>
          <div class="card-body">
            <p class="card-text">{{$product->describe}}</p>
          </div>
        </div>
        <div class="row">
    </div>
@endsection
