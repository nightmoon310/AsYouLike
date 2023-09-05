@extends('layout.layout')

@section('content')
<br>
<div class="container">
      <fieldset>
      <legend>訂單列表</legend>
      @if(!empty($msg))
        <span class="text-danger">{{$msg}}</span>
      @endif
      @if(!empty($data))
      <div class="accordion" id="accordionGroup">
        @foreach($data as $groupid => $orders)
        <div class="accordion-item">
          <h2 class="accordion-header" id="heading{{$groupid}}">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$groupid}}" aria-expanded="false" aria-controls="collapse{{$groupid}}">
                <div>訂單id：{{$groupid}}</div>
            </button>
          </h2>
          <div id="collapse{{$groupid}}" class="accordion-collapse collapse" aria-labelledby="heading{{$groupid}}" data-bs-parent="#accordionGroup" style="">
            <div class="accordion-body">
              <table class="table table-hover">
                <thead>
                  <tr class="table-light">
                    <th scope="col">商品名稱</th>
                    <th scope="col">商品價格</th>
                    <th scope="col">數量</th>
                    <th scope="col">小計</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                  <tr class="table-light">
                    <td width="50%"><a target="_blank" href="/p/{{$order['productid']}}/?{{$order['productname']}}">{{$order['productname']}}</td>
                    <td>${{$order['productprice']}}</td>
                    <td>{{$order['count']}}</td>
                    <td class="text-danger" >${{$order['totalprice']}}</td>
                  </tr>
                @endforeach
                  <tr class="table-light">
                    <td colspan="4">
                      <div class="row">
                        <label for="inputAddress" class="col-sm-2 col-form-label">寄送地址：</label>
                        <div class="col-sm-10">
                          <input type="text" name="address" class="form-control" value="{{$data[$groupid][0]['address']}}" disabled>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr class="table-light">
                    <td colspan="3"></td>
                    <td>總金額：<span class="text-danger">${{$total_price_group[$groupid]}}</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        @endforeach
      @endif
      </fieldset>
</div>
@endsection
