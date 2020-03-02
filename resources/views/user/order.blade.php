@extends('layouts.dashboard') @if (session('status'))
<div class="alert alert-success" role="alert">{{ session('status') }}</div>
@endif @section('content')
<div class="container">
	<!-- #masthead -->
	<header id="masthead" class="site-header">
		<div class="site-branding">
			<h1 class="site-title">Dashboard</h1>
		</div>
		@include('includes.user.navbar')
	</header>
 	<div id="content" class="site-content">
	    @include('includes.error')
        @include('includes.success')
		<div id="primary" class="content-area column full">
			<main id="main" class="site-main" role="main">
				<div id="container">
					<div id="content" role="main">
					<h2 class="entry-title">Order #{{$order->order_number}} - {{$order->order_status}} - {{$order->updated_at}}</h2>
					<hr>
					 <div class="wpcmsdev-columns">
						<div class="column column-width-one-half">
							<p>
							   <strong>Billing address:	</strong><br>
							   Name: {{ $order->addresses[0]->first_name }} {{ $order->addresses[0]->last_name }}<br>
							   Email: {{ $order->addresses[0]->email }}<br>
							   Phone: {{ $order->addresses[0]->phone }}<br>
							   Address: {{ $order->addresses[0]->zip_code }} {{ $order->addresses[0]->address }} {{ $order->addresses[0]->city }} {{ $order->addresses[0]->country }} {{ $order->addresses[0]->state }}
							</p>													
						</div>
						<div class="column column-width-one-half">
						    @if(isset($order->addresses[1]))
							<p>
							   <strong>Shipping address:	</strong><br>
							   Name: {{ $order->addresses[1]->first_name }} {{ $order->addresses[1]->last_name }}<br>
							   Email: {{ $order->addresses[1]->email }}<br>
							   Phone: {{ $order->addresses[1]->phone }}<br>
							   Address: {{ $order->addresses[1]->zip_code }} {{ $order->addresses[1]->address }} {{ $order->addresses[1]->city }} {{ $order->addresses[1]->country }} {{ $order->addresses[1]->state }}							
							</p>
							@endif
						</div>
					</div>
					<hr>
		             @foreach($products as $store_id => $store)
						<h2 class="entry-title">
							Store: <a href="{{ route('storePage.show', $store_id) }}">{{$store['store_title']}}</a>
						</h2>
						<br>
						<table id="order_products" class="table table-hover table-condensed">
							<thead>
								<tr>
									<th style="width: 35%">Product</th>
									<th style="width: 15%">Sku</th>
									<th style="width: 10%">Price</th>
									<th style="width: 8%">Quantity</th>
									<th style="width: 22%" class="text-center">Subtotal</th>
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
													<a href="{{route('productPage.show', $product_id) }}">{{
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
									<td data-th="Quantity">{{ $item['product_quantity'] }}</td>
									<td data-th="Subtotal" class="text-center">${{ $price *
										$item['product_quantity'] }}</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<td><a href="{{ route('storePage.show', $store_id) }}" class="btn btn-warning"><i
											class="fa fa-angle-left"></i> Go to the Store</a></td>
									<td colspan="3" class="hidden-xs"></td>
									<td class="hidden-xs text-center"><strong>Total: ${{ $total }}</strong></td>
								</tr>
							</tfoot>
						</table>
						@endforeach
					   <hr>
					   <div class="wpcmsdev-columns">
						<div class="column column-width-two-thirds">
						  <b>Comments to the order:</b>
						  @foreach($order->comments as $comment) 
						   @if(!empty($comment->order_comment))
							<p>
							  @if($comment->store_id == 0)
							    <b>{{ $comment->updated_at }}:</b> {{ $comment->order_comment }}
							  @else
							    <b><a href="{{ route('storePage.show', $comment->store_id) }}">Store</a> - {{ $comment->updated_at }}:</b> {{ $comment->order_comment }}
							  @endif
							</p>
						   @endif	
						  @endforeach	
						</div>
						<div class="column column-width-one-third">
							<p>
							   <b>Shipping Amount: ${{ $order->shipping_amount }}</b>
							</p>
							<p>
							   <b>Payment fee: ${{ $order->payment_fee }}</b>
							</p>	
							<p>
							  <b> Grand amount: ${{ $order->total_amount }}</b>
							</p>													
						</div>
					   </div>
					  <hr>
					</div>
				</div>
			</main>
			<!-- #main -->
		</div>
		<!-- #primary -->
	</div>
	<!-- #content -->
</div>
@endsection