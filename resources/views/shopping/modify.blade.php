@extends('layout.layout')

@section('content')
    <br>
    <div class="container">
        <!-- Content here -->
        <form action="{{action('Shopping\ShoppingController@modify')}}" method="POST">
            @csrf
            <fieldset>
                <legend>會員資料</legend>
                <div class="form-group">
                    <label for="name" class="form-label mt-4">會員暱稱</label>
                    <input type="text" name="name" class="form-control" value="{{$data->name}}">
                </div>
                <div class="form-group">
                    <label for="account" class="form-label mt-4">帳號</label>
                    <input type="text" name="account" class="form-control" value="{{$data->account}}" disabled>
                </div>
                <div class="form-group">
                    <label for="Password" class="form-label mt-4">密碼</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="tel" class="form-label mt-4">電話號碼</label>
                    <input type="text" name="tel" class="form-control" value="{{$data->tel}}">
                </div>
                <div class="form-group">
                    <label for="tel" class="form-label mt-4">e-mail</label>
                    <input type="text" name="email" class="form-control" value="{{$data->email}}">
                </div>
                <div class="form-group">
                    <label for="tel" class="form-label mt-4">生日</label>
                    <input type="text" name="birth" class="form-control" value="{{$data->birth}}" disabled>
                </div>
                <div class="form-group">
                    <label for="address" class="form-label mt-4">地址</label>
                    <input type="text" name="address" class="form-control" value="{{$data->address}}">
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
