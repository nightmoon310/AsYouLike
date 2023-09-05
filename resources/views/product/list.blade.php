@extends('layout.layout')

@section('content')
  <br>
  <div class="container">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col" colspan="5">
            <a class="btn btn-primary" href="/product/add">新增商品</a>
          </th>
          <!-- <th scope="col">縮圖</th> -->
        </tr>
        <tr class="table-info">
          <th scope="col">圖片</th>
          <th scope="col">商品名稱</th>
          <th scope="col">價格</th>
          <th scope="col">庫存</th>
          <th scope="col">修改</th>
          <!-- <th scope="col">縮圖</th> -->
        </tr>
      </thead>
      <tbody>
        @foreach ($products as $product)
        <tr>
          <td><img src="{{$product->picture}}" width="50px"></td>
          <td scope="col">{{$product->name}}</td>
          <td scope="col">{{$product->price}}</td>
          <td scope="col">{{$product->stock}}</td>
          <th scope="col">
            <!-- <a class="btn btn-info" href="/product/single">詳細資料</a> -->
            <a class="btn btn-info" href="/product/modify?productid={{$product->id}}">修改商品</a>
          </th>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
