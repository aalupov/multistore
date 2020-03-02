@extends('layouts.admin.main') 
@section('content')

    <!-- Main content -->
    <div class="content">
     @include('includes.error')
     @include('includes.success')
    <!-- SEARCH FORM -->
      <form method="get" action="{{ route('findOrderAdminPanel') }}" class="form-inline ml-3" name="find_order" id="find_order">
         @csrf
         {{ method_field('GET') }}
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" name="find_order" type="search" placeholder="Search Order by Number" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form><br> 
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Number</th>
      <th scope="col">User</th>
      <th scope="col">Date</th>
      <th scope="col">Status</th>      
      <th scope="col">Total</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
   @foreach($orders as $order)
    <tr>
      <th scope="row"><a href="{{ route( 'adminOrders.show', $order->id ) }}">{{ $order->order_number }}</a></th>
      @if(isset($order->name))
       <td>{{ $order->name }}</td>
      @else
       <td>Guest</td>
      @endif 
      <td>{{ $order->updated_at }}</td>
      <td>{{strtoupper($order->order_status) }}</td>
      <td>{{ $order->total_amount }}</td>    
	  <td data-th="order_view">
           <a href="{{ route( 'adminOrders.show', $order->id ) }}">
			  <button type="submit" class="btn btn-primary">View</button>
		   </a>
	  </td>  									    
    </tr>
   @endforeach
  </tbody>
</table>
  {{ $orders->links() }}
    </div>
    <!-- /.content -->

@endsection