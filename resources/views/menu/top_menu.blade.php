<br>
<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          @if(empty(session('accountsell')))
            <a class="navbar-brand" href="/">AsYouLike</a>
          @else
            <a class="navbar-brand" href="/seller/homepage">AsYouLike</a>
          @endif
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor03">
                <ul class="navbar-nav me-auto">
                    @if(empty(session('accountbuy')) && empty(session('accountsell')))
                    <!-- 未登入 -->
                    <li class="nav-item">
                        <a class="nav-link" href="/shopping/login">會員登入
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/shopping/addUser">會員註冊
                        </a>
                    </li>
                    @elseif (!empty(session('accountbuy')))
                    <!-- 買家 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><ion-icon name="logo-octocat" style="width: 18px;height: 18px"></ion-icon> {{session('accountbuy')}}</a>
                        <div class="dropdown-menu">
                            <a class="nav-link" href="/shopping/modifyUser">會員資料</a>
                            <a class="nav-link" href="/shoppingcart/cart">購物車</a>
                            <a class="nav-link" href="/order/userOrders">訂單列表</a>
                            <a class="nav-link" href="/shopping/logout">登出</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/seller/change">賣家中心
                        </a>
                    </li>
                    @elseif (!empty(session('accountsell')))
                    <!-- 賣家 -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><ion-icon name="logo-snapchat" style="width: 18px;height: 18px"></ion-icon> {{session('accountsell')}}</a>
                        <div class="dropdown-menu">
                            <a class="nav-link" href="/seller/modify">賣場資料</a>
                            <a class="nav-link" href="/product/list">商品列表</a>
                            <a class="nav-link" href="/product/add">新增商品</a>
                            <a class="nav-link" href="/order/sellerOrders">訂單列表</a>
                            <a class="nav-link" href="/seller/logout">登出</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/shopping/change">買家中心
                        </a>
                    </li>
                    @endif
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">賣家中心</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">修改資料</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li> -->
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Separated link</a>
                        </div>
                    </li> -->
                </ul>
                @if(empty(session('accountsell')))
                <form class="d-flex" action="{{action('Shopping\ShoppingController@getHomepage')}}" method="GET">
                    <input class="form-control me-sm-2" type="text" name="search" placeholder="Search" value="<?php if(!empty($search)){ echo $search;}?>">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
                </form>
                @endif
            </div>
        </div>
    </nav>
</div>
