<div class="entry-content">

	<div class="wpcmsdev-columns">
		<div class="column column-width-one-third">
			<a href="{{ route('storePage.show', $storeInfo->id) }}"> <img
				src="{{ asset('upload/store') }}/{{$storeInfo->store_picture}}"
				alt="{{$storeInfo->store_title}}" />
			</a>
		    <div>
			      <i class="fa fa-star fa-lg"></i>
				    @for ($i = 2; $i <= $storeInfo->store_rating; $i++)
				      <i class="fa fa-star fa-lg"></i>
				    @endfor 
		   </div>
		</div>
		<div class="column column-width-one-third">
		<!-- 	<a class="wpcmsdev-button color-blue"
				href="/store/{{$storeInfo->id}}"> <span>{{$storeInfo->store_title}}</span></a>  -->
			<ul>
			     <li>
                    <h4>{{$storeInfo->store_title}}</h4></li>
			     </li>
				<li><b>City:</b> {{$storeInfo->store_city}}</li>
				<li><b>Address:</b> {{$storeInfo->store_address}}</li>
				<li><b>Phone:</b> {{$storeInfo->store_phone}}</li>
				<li><b>Email:</b> {{$storeInfo->store_email}}</li>
				<li>
			      @if ($storeInfo->store_status)
				    <b><font color="green">OPENED</font></b>
				  @else
				     <b><font color="red">CLOSED</font></b> 
				  @endif 
				</li>
			</ul>
		</div>
		<div class="column column-width-one-third">
			<div style="width: 100%">
				<iframe width="300" height="265" frameborder="0" style="border: 0"
					src="{{ route('googleMapStore.show', $storeInfo->id) }}" allowfullscreen> </iframe>
			</div>
			@if (isset($storeInfo->social_links))
		     	<div>{!! $storeInfo->social_links->twitter !!} {!! $storeInfo->social_links->facebook !!} {!! $storeInfo->social_links->instagram !!}</div>
            @endif
		</div>
	</div>
</div>