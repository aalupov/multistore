<div id="page">
    <div id="app">
      <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>
                    <form id="find_product_form" action="{{ route('findProducts') }}" method="GET">
                     <div class="input-group mb-3">
                       @csrf
                        <input type="text" class="form-control" placeholder="Find a Product" aria-label="" 
                          aria-describedby="button-addon2"
                          name="find_product" id="find_product">                           
                         <div class="input-group-append">
                           <button class="btn btn-outline-secondary" type="submit" id="button-addon2">FIND</button>
                         </div>   
                     </div>
                    </form> 
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">                    
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        {{ __('Dashboard') }}
                                    </a>                  
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        @if(session('cart') && isset($totalInCart) )
                         <!-- Link to Cart -->
                            <li class="nav-item">
                              <div class="row">
                               <div class="col-lg-12 col-sm-12 col-12 main-section">
                                   <div class="dropdown">
                                    <button type="button" class="btn btn-info" data-toggle="dropdown">                                     
                                       <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger">{{ $totalInCart['products'] }}</span> 
                                    </button>
                                   <div class="dropdown-menu">
                                    <div class="row total-header-section">
                                      <div class="col-lg-12 col-sm-12 col-12">
                                        <p>Total: <span class="text-info">$ {{ $totalInCart['price'] }}</span></p>
                                      </div>
                                   </div>
                                    <div class="row">
                                      <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                         <a href="{{ route('cartStores') }}" class="btn btn-primary btn-block">View all</a><br>
                                     </div>
                                   </div>
                                    <div class="row">
                                      <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                         <a href="{{ route('checkoutStores') }}" class="btn btn-primary btn-block">Checkout</a>
                                     </div>
                                   </div>
                                 </div>
                                </div>
                              </div>
                         </div>
                       </li>
                       <!-- Link to Cart -->                        
                       @endif
                    </ul>
                </div>
            </div>
      </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    	<footer id="colophon" class="site-footer">
	<div class="container">
		<div class="site-info">
			<h1 style="font-family: 'Herr Von Muellerhoff';color: #ccc;font-weight:300;text-align: center;margin-bottom:0;margin-top:0;line-height:1.4;font-size: 46px;">MultiStore</h1>
			Demo MultiStore Site(c)

		</div>
	</div>	
	</footer>
	<a href="#top" class="smoothup" title="Back to top"><span class="genericon genericon-collapse"></span></a>
</div>
</div>
<!-- #page -->