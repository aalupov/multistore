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
						<table id="orders" class="table table-hover table-condensed">
							<thead>
								<tr>
									<th style="width: 20%">Order Number</th>
									<th style="width: 20%">Shipping Amount</th>
									<th style="width: 20%">Payment Fee</th>
									<th style="width: 20%">Total Amount</th>
									<th style="width: 20%">Order Status</th>
								</tr>
							</thead>
							<tbody>
							@foreach($orders as $item)
                            <tr>
									<td data-th="order_number">
										<div class="row">
											<div class="col-sm-9">
												<h4 class="nomargin">
													<a href="{{ route('orderUser.show', $item->id) }}">{{
														$item->order_number }}</a>
												</h4>
											</div>
										</div>
									</td>
									<td data-th="shipping_amount">${{ $item->shipping_amount }}</td>
									<td data-th="payment_fee">${{ $item->payment_fee }}</td>
									<td data-th="total_amount">${{ $item->total_amount }}</td>
									<td data-th="order_status">{{ strtoupper($item->order_status) }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
				  </div>
				  <nav class="pagination">{{ $orders->links() }}</nav>
				</div>
			</main>
			<!-- #main -->
		</div>
		<!-- #primary -->
	</div>
	<!-- #content -->
</div>
@endsection
