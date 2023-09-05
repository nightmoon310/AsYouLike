<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
@extends('layout.layout')

@section('content')
  <br>
  <div class="container">
      <!-- Content here -->
      <form action="{{action('Shopping\ShoppingController@login')}}" method="POST">
          @csrf
          <fieldset>
              <legend>會員登入</legend>
              <div class="form-group">
                  <label for="account" class="form-label mt-4">帳號</label>
                  <input type="text" name="account" class="form-control">
              </div>
              <br>
              <div class="form-group">
                  <label for="Password" class="form-label mt-4">密碼</label>
                  <input type="password" name="password" class="form-control">
              </div>
              <br>
              <div class="form-group">
                  <label for="submit" class="form-label mt-4"></label>
                  <input type="hidden" name="comf" value="1">
                  <button type="submit" class="btn btn-outline-primary">登入資料</button>
                  <span class="text-danger">{{$msg}}</span>
              </div>
          </fieldset>
      </form>
  </div>
@endsection
