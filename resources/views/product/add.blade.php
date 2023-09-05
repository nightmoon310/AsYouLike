@extends('layout.layout')

@section('content')
    <br>
    <div class="container">
        <!-- Content here -->
        <form action="{{action('Product\ProductController@add')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <fieldset>
                <legend>新增商品</legend>
                <div class="form-group">
                    <label for="name" class="form-label mt-4">商品名稱</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="price" class="form-label mt-4">價格</label>
                    <input type="text" name="price" class="form-control">
                </div>
                <div class="form-group">
                    <label for="stock" class="form-label mt-4">庫存量</label>
                    <input type="text" name="stock" class="form-control">
                </div>
                <div class="form-group">
                    <label for="describe" class="form-label mt-4">商品描述</label>
                    <input type="text" name="describe" class="form-control">
                </div>
                <div class="form-group">
                    <label for="picture" class="form-label mt-4">圖片</label>
                    <input type="file" name="picture" accept="image/png, image/bmp, image/jpeg" class="form-control">
                </div>
                <div class="form-group">
                    <label for="submit" class="form-label mt-4"></label>
                    <input type="hidden" name="comf" value="1">
                    <button type="submit" class="btn btn-primary">新增資料</button>
                    <span class="text-danger">{{$msg}}</span>
                </div>
            </fieldset>
        </form>
    </div>
@endsection
