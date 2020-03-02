@extends('layouts.cart') @section('content')

<div class="container">
	<!-- #masthead -->
	<header id="masthead" class="site-header">
		<div class="site-branding">
			<h1 class="site-title">Shopping Cart</h1>
		</div>
	</header>
	<div id="content" class="site-content">
	    @include('includes.error')
        @include('includes.success')
		<div id="primary" class="content-area column full">
			<main id="main" class="site-main" role="main">
				<div id="container">
					<div id="content" role="main">
						@if(session('cart')) @foreach(session()->get('cart') as $store_id
						=> $store)
						<h2 class="entry-title">
							Store: <a href="{{ route('storePage.show', $store_id) }}">{{$store['store_title']}}</a>
						</h2>
						<br>
              <form action="{{ route('updateCart') }}" class="cart" method="post" enctype='multipart/form-data'>
                @csrf
				<input id="store_id" name="store_id" type="hidden" value="{{$store_id}}">
				<input id="store_title" name="store_title" type="hidden" value="{{$store['store_title']}}">
						<table id="cart" class="table table-hover table-condensed">
							<thead>
								<tr>
									<th style="width: 35%">Product</th>
									<th style="width: 15%">Sku</th>
									<th style="width: 10%">Price</th>
									<th style="width: 8%">Quantity</th>
									<th style="width: 22%" class="text-center">Subtotal</th>
									<th style="width: 10%"></th>
								</tr>
							</thead>
							<tbody>
 
        <?php $total = 0; unset($store['store_title']); ?>
 
         @foreach($store as $product_id => $item)
         <input id="product_id[{{$product_id}}]" name="product_id[{{$product_id}}]" type="hidden" value="{{$product_id}}">
            @if(!empty($item['product_sale_price']))
              <?php $price =$item['product_sale_price'] ?>
            @else
               <?php $price =$item['product_regular_price'] ?>
            @endif
             <?php $total += $price * $item['product_quantity'];  ?> 
 
                <tr>
									<td data-th="Product">
										<div class="row">
											<div class="col-sm-3 hidden-xs">
												<img src="/upload/product/{{ $item['product_picture'] }}"
													width="100" height="100" class="img-responsive" />
											</div>
											<div class="col-sm-9">
												<h4 class="nomargin">
													<a href="{{ route('productPage.show', $product_id) }}">{{
														$item['product_title'] }}</a>
												</h4>
												@if(!empty($item['attribute_values']))
												  <div>
												     @foreach($item['attribute_values'] as $attribute => $value)
												        {{ $attribute }}: {{ $value }}
												     @endforeach
												  </div>
												@endif  
											</div>
										</div>
									</td>
									<td data-th="Sku">{{ $item['product_sku'] }}</td>
									<td data-th="Price">${{ $price }}</td>
									<td data-th="Quantity"><input type="number"
									    name="quantity[{{$product_id}}]"
										value="{{ $item['product_quantity'] }}"
										class="form-control quantity" /></td>
									<td data-th="Subtotal" class="text-center">${{ $price *
										$item['product_quantity'] }}</td>
									<td class="actions" data-th="">
										<button class="btn btn-info btn-sm update-cart"
										    type="submit"
										    name="update"
										    value="update-cart">
											<i class="fa fa-refresh"></i>
										</button>
										<button class="btn btn-danger btn-sm remove-from-cart"
										    type="submit"
										    name="remove"
										    value="{{$product_id}}"
										    onclick="return confirm('Are you sure?')">
											<i class="fa fa-trash-o"></i>
										</button>
									</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<td><a href="{{ route('storePage.show', $store_id) }}" class="btn btn-warning"><i
											class="fa fa-angle-left"></i> Back to the Store</a></td>
									<td colspan="4" class="hidden-xs"></td>
									<td class="hidden-xs text-center"><strong>Total: ${{ $total }}</strong></td>
								</tr>
							</tfoot>
						</table>
						</form>
						@endforeach
						<form action="{{ route('clearCart') }}" class="clear_cart" method="post" enctype='multipart/form-data'>
						@csrf
						<table id="clear_cart" class="table table-hover table-condensed">
						 <tfoot>
							<tr>						    
                               @csrf					
							      <td colspan="4" class="hidden-xs"></td>
                                  <td><button type="submit"
									class="wpcmsdev-button color-red"
									name="clear_cart"
									value="1"
									onclick="return confirm('Are you sure?')">Clear Cart</button></td>								
							</tr>
						 </tfoot>
						</table>
						</form>						
						<table id="go_to_checkout" class="table table-hover table-condensed">
						 <tfoot>
							<tr>
								<td><a href="{{ route('checkoutStores') }}"><button type="button"
											class="wpcmsdev-button color-blue">Go to Checkout</button></a></td>
								<td colspan="4" class="hidden-xs"></td>
								<td class="hidden-xs text-right"><strong>Grand Total: ${{
										$totalInCart['price'] }}</strong></td>
							</tr>
						 </tfoot>
						</table>
						@else
						<div class="alert alert-info" role="alert">
							You have no items in your shopping cart.<br> Click <a href="/">here</a>
							to continue shopping.
						</div>
						@endif
					</div>
				</div>
			</main>
			<!-- #main -->
		</div>
		<!-- #primary -->
	</div>
	<!-- #content -->
</div>
<!-- .container -->
@endsection