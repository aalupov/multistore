@extends('layouts.admin.main') 
@section('content')

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Total Sales</h5>
              </div>
              <div class="card-body">

                <p class="card-text"><h1>Total Sales <span class="badge badge-secondary">$ {{ $total }}</span></h1></p>

              </div>
            </div>

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Latest Stores</h5>
              </div>
              <div class="card-body">               
                @foreach($stores as $store) 
                  <p class="card-text"><b><a href="{{ route('adminStores.show', $store->id) }}">{{ $store->store_title }}</a></b></p>
                @endforeach
                <a href="{{ route('adminStores.index') }}" class="btn btn-primary">Go to Stores</a>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Latest Customers</h5>
              </div>
              <div class="card-body">
                @foreach($users as $user) 
                  <p class="card-text"><b>{{ $user->name }}</b> - {{ $user->email }} </p>
                @endforeach
                <a href="{{ route('adminUsers.index') }}" class="btn btn-primary">Go to Users</a>
              </div>
            </div>

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Latest Orders</h5>
              </div>
              <div class="card-body">
                @foreach($orders as $order) 
                  <p class="card-text"><b><a href="{{ route('adminOrders.show', $order->id) }}">{{ $order->order_number }} - {{ $order->updated_at }} - {{ $order->order_status }}</a></b></p>
                @endforeach
                <a href="{{ route('adminOrders.index') }}" class="btn btn-primary">Go to Orders</a>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

@endsection