@extends('layouts.admin.main') 
@section('content')

    <!-- Main content -->
    <div class="content">
     @include('includes.error')
     @include('includes.success')
                         <div class="form-group row mb-0">
                               <a href="{{ route('adminOrders.index') }}">
                                <button type="button" class="btn btn-secondary btn-lg">
                                    {{ __('<<Back') }}
                                </button> 
                               </a>   
                        </div>
		<div id="primary" class="content-area column full">
			<main id="main" class="site-main" role="main">
				<div id="container">
					<div id="content" role="main">
					<h2 class="entry-title">Order #{{$order->order_number}} - {{strtoupper($order->order_status)}} - {{$order->updated_at}} - {{$order->ip_address}}</h2>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Billing address</h5>
              </div>
              <div class="card-body">
                <p class="card-text">
                    Name: {{ $order->addresses[0]->first_name }} {{ $order->addresses[0]->last_name }}<br>
					Email: {{ $order->addresses[0]->email }}<br>
					Phone: {{ $order->addresses[0]->phone }}<br>
					Address: {{ $order->addresses[0]->zip_code }} {{ $order->addresses[0]->address }} {{ $order->addresses[0]->city }} {{ $order->addresses[0]->country }} {{ $order->addresses[0]->state }}
                </p>

              </div>
            </div>
          </div>
          @if(isset($order->addresses[1]))
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Shipping address</h5>
              </div>
              <div class="card-body">
                <p class="card-text">
                    Name: {{ $order->addresses[1]->first_name }} {{ $order->addresses[1]->last_name }}<br>
		            Email: {{ $order->addresses[1]->email }}<br>
					Phone: {{ $order->addresses[1]->phone }}<br>
					Address: {{ $order->addresses[1]->zip_code }} {{ $order->addresses[1]->address }} {{ $order->addresses[1]->city }} {{ $order->addresses[1]->country }} {{ $order->addresses[1]->state }}		
                </p>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
          @endif
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
					<hr>
		             @foreach($products as $store_id => $store)
						<h2 class="entry-title">
							Store: <a href="{{ route('adminStores.show', $store_id) }}">{{$store['store_title']}}</a>
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
									<td colspan="3" class="hidden-xs"></td>
									<td class="hidden-xs text-center"><strong>Total: ${{ $total }}</strong></td>
								</tr>
							</tfoot>
						</table>
						@endforeach
					   <hr>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Comments</h5>
              </div>
              <div class="card-body">
                <p class="card-text">
						  @foreach($order->comments as $comment) 
						   @if(!empty($comment->order_comment))
							<p>
							  @if($comment->store_id == 0)
							   <b>{{ $comment->updated_at }}:</b> {{ $comment->order_comment }}
							  @else
							   <b><a href="{{ route('adminStores.show', $comment->store_id) }}">Store</a> - {{ $comment->updated_at }}:</b> {{ $comment->order_comment }}
							  @endif 
							</p>
						   @endif	
						  @endforeach	                
                </p>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
               <div class="card-header">
                <h5 class="m-0">Totals</h5>
              </div>           
              <div class="card-body">
                <p class="card-text">
							<p>
							   <b>Shipping Amount: ${{ $order->shipping_amount }}</b>
							</p>
							<p>
							   <b>Payment fee: ${{ $order->payment_fee }}</b>
							</p>	
							<p>
							  <b> Grand amount: ${{ $order->total_amount }}</b>
							</p>		
                </p>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->					   
					  <hr>
				<form method="post" action="{{ route('adminOrders.update', $id) }}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <label class="input-group-text" for="status">Order status</label>
  </div>
  <select class="custom-select" id="status" name="status">
    @foreach($statuses as $item)
      <option value="{{ $item->id }}">{{ $item->order_status }}</option>
    @endforeach
  </select>    
</div>
<div class="input-group">
  <div class="input-group-prepend">
    <span class="input-group-text">Add Comment</span>
  </div>
  <textarea class="form-control" aria-label="comment" name="comment"></textarea>
</div><br>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    {{ __('Update') }}
                                </button>                                
                            </div>
                         </div>   <br>
</form>				  
					</div>
				</div>
			</main>
			<!-- #main -->
		</div>
		<!-- #primary -->
                         <div class="form-group row mb-0">
                               <a href="{{ route('adminOrders.index') }}">
                                <button type="button" class="btn btn-secondary btn-lg">
                                    {{ __('<<Back') }}
                                </button> 
                               </a>   
                        </div>
    </div>
    <!-- /.content -->

@endsection