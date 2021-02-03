<?php   
   $cartCount = isset($_COOKIE['item_id']) ? count($_COOKIE['item_id']) : 0;
    if(session()->has('seller')){
        $orderCount = DB::table('orders')->where('seller_id','=',session()->get('seller')->id)->sum('count');
    }
?>
<nav class="navbar navbar-dark bg-dark navbar-expand-lg ">
    <a class="navbar-brand" href="/">E-Commerce</a>
    <div class="container">
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                @if(session()->has('seller'))
                    <li class="nav-item active">
                        <a class="nav-link" href="/my-items">my items</a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php 
                            if(session()->has('seller')){
                                echo session()->get('seller')->username;
                            }elseif(session()->has('customer')){
                                echo session()->get('customer')->username;
                            }else {
                                echo 'welcome';
                            }
                        ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        
                        <?php 
                            if(session()->has('seller')){
                                echo '<span class="dropdown-item" href="#">role : ' . session()->get('seller')->role . '</span>';
                                echo '<a class="dropdown-item" href="#">my profile</a>';
                                echo '<a class="dropdown-item" href="/view-order">orders('.$orderCount.')</a>';
                            }else{
                                if(session()->has('customer')){
                                    echo '<span class="dropdown-item" href="#">role : ' . session()->get('customer')->role . '</span>';
                                }
                                echo '<a class="dropdown-item" href="/view-cart">cart('. $cartCount .')</a>';
                            }
                        ?>

                        @if (session()->has('seller') || session()->has('customer'))
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{route('logout')}}">logout</a>
                        @else  
                            <a class="dropdown-item" href="/login">login</a>
                        @endif
                        
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="GET" action="/">
                <input class="form-control mr-sm-2" type="search" name="q" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>
