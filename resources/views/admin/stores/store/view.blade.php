@extends('layouts.admin.store') 
@section('content')

    <!-- Main content -->
    <div class="content">
     @include('includes.error')
     @include('includes.success')

<div class="card" style="width: 20rem;">
  <img src="{{ url('upload/store') }}/{{ $storeInfo->store_picture }}" class="card-img-top" alt="{{ $storeInfo->store_title }}">
  <div class="card-body">
    <h5 class="card-title"><strong>{{ $storeInfo->store_title }}</strong></h5>
    <p class="card-text">{{ $storeInfo->store_description }}</p>
    <p class="card-text">{{ $storeInfo->store_email }}</p>
    <p class="card-text">{{ $storeInfo->store_phone }}</p>
    <p class="card-text">{{ $storeInfo->store_address }} {{ $storeInfo->store_city }} {{ $storeInfo->store_country }} {{ $storeInfo->store_state }}</p>
    <p class="card-text">lat: {{ $storeInfo->store_lat }} , lon: {{ $storeInfo->store_lon }}</p>
    <p class="card-text">
     @if(isset($storeInfo->time_shedule))
       @foreach($storeInfo->time_shedule as $items)
	       @if ($items->opened_at != NULL)
		     <b>{{$items->day_of_week}}</b>: {{$items->opened_at}} to {{$items->closed_at}}<br>
		   @else
		     <b>{{$items->day_of_week}}</b>: Closed<br>
		  @endif
	   @endforeach	
	 @endif  
	</p>
    <p class="card-text">
      @if (isset($storeInfo->social_links))
		  {!! $storeInfo->social_links->twitter !!} 
		  {!! $storeInfo->social_links->facebook !!}
		  {!! $storeInfo->social_links->instagram !!}
      @endif
    </p>  
    @if($storeInfo->store_is_activated)
     <p class="card-text"><strong><font color="green">Active</font></strong></p>
    @else
     <p class="card-text"><strong><font color="red">Unactive</font></strong></p> 
    @endif 
    <a href="{{ route( 'adminStorePanel.edit', $id ) }}" class="btn btn-primary btn-block">Edit</a>
  </div>
</div>
 
                         <div class="form-group row mb-0">
                               <a href="{{ route('homeStorePanel.show', $id) }}">
                                <button type="button" class="btn btn-secondary btn-lg">
                                    {{ __('<<Back') }}
                                </button> 
                               </a>   
                        </div>
    <!-- /.content -->
</div>
@endsection