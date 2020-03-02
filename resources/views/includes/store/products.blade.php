	<!-- #masthead -->
	<div id="content" class="site-content">
	    @include('includes.error')
        @include('includes.success')
		<div id="primary" class="content-area column full">
		  <form action="{{ route('sortProducts') }}" class="woocommerce-ordering" id="sort_products" method="get">
		  @csrf
		    <input id="store_id" name="store_id" type="hidden" value="{{$storeInfo->id}}">
		    @if (isset($id))
		      <input id="category_id" name="category_id" type="hidden" value="{{$id}}">
		    @endif  
			<select name="orderby" class="orderby" onchange="this.form.submit()">
				<option value="menu_order" selected="selected">Default sorting</option>
				<option value="rating">Sort by average rating</option>
				<option value="regular_price">Sort by price</option>
			</select>
		  </form>
			@if(isset($products))		  
			<main id="main" class="site-main" role="main">
				<ul class="products">
					@foreach($products as $item)

					<li class="product"><a href="{{ route('productPage.show', $item->id) }}"> 
					  <div>
					     <i class="fa fa-star fa-lg"></i>
		                 @for ($i = 2; $i <= $item->rating; $i++)
					         <i class="fa fa-star fa-lg"></i>
						 @endfor
					   </div> 
					 @if (!empty($item->product_sale_price)) 
					      <span class="onsale">Sale!</span>
					 @endif 
					 <img src="/upload/product/{{$item->product_picture}}"
							alt="">
						<h3>{{$item->product_title}}</h3> 
						<span class="price">
							@if (!empty($item->product_sale_price)) 
							  <span
								 class="amount"><strike>{{$item->product_regular_price}}</strike>
							  </span>
							  <span
								 class="amount">{{$item->product_sale_price}}
							  </span>
							@else
							  <span
								  class="amount">{{$item->product_regular_price}}
							  </span>
					        @endif 			
					   </span>
					</a>
					 @include('includes.addtocart')</li>
					 @endforeach
				</ul>
				<ul class="page-numbers">{{ $products->links() }}
				</ul>
			</main>
			@endif 			
			<!-- #main -->
		</div>
		<!-- #primary -->
	</div>
	<!-- #content -->