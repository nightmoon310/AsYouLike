@extends('layout.layout')

@section('content')
    <br>
    <div class="container">
        <!-- Content here -->
        <form action="{{action('Product\ProductController@modify')}}" method="POST">
            @csrf
            <fieldset>
                <legend>商品資料修改</legend>
                <div class="form-group">
                    <label for="name" class="form-label mt-4">商品名稱</label>
                    <input type="text" class="form-control" value="{{$data->name}}" readonly="">
                </div>
                <div class="form-group">
                    <label for="price" class="form-label mt-4">價格</label>
                    <input type="text" name="price" class="form-control" value="{{$data->price}}">
                </div>
                <div class="form-group">
                    <label for="stock" class="form-label mt-4">庫存</label>
                    <input type="text" name="stock" class="form-control" value="{{$data->stock}}">
                </div>
                <div class="form-group">
                    <label for="describe" class="form-label mt-4">商品描述</label>
                    <textarea type="text" name="describe" class="form-control" rows="5">{{$data->describe}}</textarea>
                </div>
                <div class="form-group">
                    <label for="picture" class="form-label mt-4">圖片</label></br>
                    <img src="{{$data->picture}}" width="400px">
                </div>
                <div class="form-group">
                    <label for="submit" class="form-label mt-4"></label>
                    <input type="hidden" name="productid" value="{{$data->id}}">
                    <input type="hidden" name="comf" value="1">
                    <button type="submit" class="btn btn-primary">修改資料</button>
                    <span class="text-danger">{{$msg}}</span>
                </div>
            </fieldset>
        </form>
    </div>
    <br>
    <br>
@endsection
