@extends('layout.layout')

@section('content')
    <br>
    <div class="container">
        <!-- Content here -->
        <form action="{{action('Shopping\ShoppingController@add')}}" method="POST">
            @csrf
            <fieldset>
                <legend>會員註冊</legend>
                <div class="form-group">
                    <label for="name" class="form-label mt-4">會員暱稱</label>
                    <input type="text" name="name" class="form-control" placeholder="請輸入1-6個中文字">
                </div>
                <div class="form-group">
                    <label for="account" class="form-label mt-4">帳號</label>
                    <input type="text" name="account" class="form-control">
                </div>
                <div class="form-group">
                    <label for="Password" class="form-label mt-4">密碼</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="rePassword" class="form-label mt-4">密碼確認</label>
                    <input type="password" name="repassword" class="form-control">
                </div>
                <div class="form-group">
                    <label for="tel" class="form-label mt-4">電話號碼</label>
                    <input type="text" name="tel" class="form-control">
                </div>
                <div class="form-group">
                    <label for="tel" class="form-label mt-4">e-mail</label>
                    <input type="text" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="tel" class="form-label mt-4">生日</label>
                    <input type="text" name="birth" class="form-control">
                </div>
                <div class="form-group">
                    <label for="address" class="form-label mt-4">地址</label>
                    <input type="text" name="address" class="form-control">
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
