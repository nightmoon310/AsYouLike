@extends('layout.layout')

@section('content')
    <br>
    <div class="container">
        <!-- Content here -->
        <form action="{{action('Seller\SellController@modify')}}" method="POST">
            @csrf
            <fieldset>
                <legend>賣場資料</legend>
                <div class="form-group">
                    <label for="account" class="form-label mt-4">帳號</label>
                    <input type="text" name="account" class="form-control" value="{{$data->account}}" disabled>
                </div>
                <div class="form-group">
                    <label for="storename" class="form-label mt-4">賣場名稱</label>
                    <input type="text" name="storename" class="form-control" value="{{$data->storename}}">
                </div>
                <div class="form-group">
                    <label for="describe" class="form-label mt-4">賣場描述</label>
                    <textarea type="text" name="describe" class="form-control" rows="5">{{$data->describe}}</textarea>
                </div>
                <div class="form-group">
                    <label for="submit" class="form-label mt-4"></label>
                    <input type="hidden" name="comf" value="1">
                    <button type="submit" class="btn btn-primary">修改資料</button>
                    <span class="text-danger">{{$msg}}</span>
                </div>
            </fieldset>
        </form>
    </div>
@endsection
