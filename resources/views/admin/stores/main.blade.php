@extends('layouts.admin.store') 
@section('content')

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Latest Orders</h5>
              </div>
              <div class="card-body">
                @foreach($orders as $order) 
                  <p class="card-text"><b><a href="{{ route('adminStorePanelOrders.edit', $order->id) }}">{{ $order->order_number }} - {{ $order->updated_at }} - {{ $order->order_status }}</a></b></p>
                @endforeach
                <a href="{{ route('adminStorePanelOrders.show', $id) }}" class="btn btn-primary">Go to Orders</a>
              </div>
             </div>
            </div>
            <div class="col-lg-6">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Latest Reviews</h5>
              </div>
              <div class="card-body">
                @foreach($reviews as $review) 
                  <p class="card-text"><b>{{ $review->customer_name }} - {{ $review->customer_email }}</b> - {{ $review->review }}</p>
                @endforeach
                <a href="{{ route('adminStorePanelReviews.show', $id) }}" class="btn btn-primary">Go to Reviews</a>
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