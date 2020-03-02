@extends('layouts.admin.store') 
@section('content')

    <!-- Main content -->
    <div class="content">
     @include('includes.error')
     @include('includes.success')
    @foreach($reviews as $review)
      <div class="container-fluid">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">{{ $review->customer_name }} - {{ $review->customer_email }} - @if($review->published)<font color="green">published</font>@else<font color="red">unpublished</font>@endif - <a href="{{ route('adminStorePanelProduct.edit', $review->product_id) }}">{{ $review->product_title }}</a> - {{ $review->updated_at }}</h5>
              </div>
              <div class="card-body">
                  <p class="card-text"><b>{{ $review->review }}</b></p> 
                <form action="{{ route( 'adminStorePanelReviews.destroy', $review->id ) }}" method="POST">@csrf {{ method_field('DELETE') }}<a href="{{ route('adminStorePanelReviews.edit', $review->id) }}" class="btn btn-success">Publishe</a> <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Remove</button></form>  
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
     @endforeach 
     {{ $reviews->links() }}
    </div>
    <!-- /.content -->


@endsection