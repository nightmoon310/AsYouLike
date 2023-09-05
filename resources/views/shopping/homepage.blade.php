@extends('layout.layout')

@section('content')
  <br>
  <div class="album py-5 bg-light">
      <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
          @foreach($products as $product)
          <div class="col">
            <a href="/p/{{$product->id}}/?{{$product->name}}">
            <div class="card shadow-sm">
              <img height="320px" class="card-img-top" role="img" src="{{$product->picture}}">
              <div class="card-body">
                <small class="card-text">{{$product->name}}</small>
                <div class="d-flex justify-content-between align-items-center">
                  <small class="text-muted"></small>
                  <small class="text-danger">${{$product->price}}</small>
                </div>
              </div>
            </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    <!-- <title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text> -->
@endsection
