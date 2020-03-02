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
									<th style="width: 20%">Name</th>
									<th style="width: 20%">Email</th>
									<th style="width: 20%">Phone</th>
									<th style="width: 15%">City</th>
									<th style="width: 15%">Zip Code</th>
									<th style="width: 5%"></th>
									<th style="width: 5%"></th>
								</tr>
							</thead>
							<tbody>
							@foreach($addresses as $item)
                            <tr>
                                    <td data-th="name">{{ $item->first_name }} {{ $item->last_name }}</td>
									<td data-th="email">{{ $item->email }}</td>
									<td data-th="phone">{{ $item->phone }}</td>
									<td data-th="city">{{ $item->city }}</td>
									<td data-th="zip_code">{{ $item->zip_code }}</td>
									<td data-th="address_edit">
                                    <a href="{{ route( 'addressUser.edit', $item->id ) }}">
									  <button type="submit" class="btn btn-info">Edit</button>
									</a>
									</td>  									
									<td data-th="address_remove">
									<form action="{{ route( 'addressUser.destroy', $item->id ) }}" method="POST">
									  @csrf
									  {{ method_field('DELETE') }}
									  <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Remove</button>
									</form>  
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<table id="add_address" class="table table-hover table-condensed">
						 <tfoot>
							<tr>
								<td><a href="{{ route('addressUser.create') }}"><button type="button"
											class="wpcmsdev-button color-blue">Add Address</button></a></td>
								<td colspan="4" class="hidden-xs"></td>
							</tr>
						 </tfoot>
						</table>
					</div>
					<nav class="pagination">{{ $addresses->links() }}</nav>
				</div>
			</main>
			<!-- #main -->
		</div>
		<!-- #primary -->
	</div>
	<!-- #content -->
 </div>
@endsection 