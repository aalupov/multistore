@extends('layouts.app') @section('content')
<div class="container">
	<!-- #masthead -->
	<header id="masthead" class="site-header">
		<div class="site-branding">
			<h1 class="site-description">Find the best dispensary in</h1>
			<h1 class="site-title">{{ $city }} . {{ $state }}</h1>
		</div>
		@include('includes.seach') @include('includes.navbar')
	</header>
	<div id="content" class="site-content">
	    @include('includes.error')
        @include('includes.success')
		<div id="primary" class="content-area column full">
		  <form action="{{ route('indexStore.store') }}" class="woocommerce-ordering" id="sort_stores" method="post">
		  @csrf
			<select name="orderby" class="orderby" onchange="this.form.submit()">
				<option value="menu_order" selected="selected">Default sorting</option>
				<option value="rating">Sort by average rating</option>
			</select>
		  </form><br>
			<main id="main" class="site-main">
				<div class="grid portfoliogrid">
					@foreach($storeList as $item)
					<article class="hentry">
						<header class="entry-header">
							<div class="entry-thumbnail">
							  <i class="fa fa-star fa-lg"></i>
							  @for ($i = 2; $i <= $item->store_rating; $i++)
							    <i class="fa fa-star fa-lg"></i>
							  @endfor  
								<a class="simple-ajax-popup" href="store/info/{{$item->id}}"><img
									src="{{ asset('upload/store') }}/{{$item->store_picture}}"
									class="attachment-post-thumbnail size-post-thumbnail wp-post-image"
									alt="{{$item->store_title}}" /></a>
							</div>
							<h2 class="entry-title">
								<a class="simple-ajax-popup" href="{{ route('shortInfoStore.show', $item->id) }}"
									rel="bookmark">{{$item->store_title}} / @if ($item->status) <b><font
										color="green">OPENED</font></b> @else <b><font color="red">CLOSED</font></b>
									@endif
								</a>
							</h2>
							<a class="portfoliotype simple-ajax-popup"
								href="{{ route('shortInfoStore.show', $item->id) }}">{{$item->store_zip}}</a> <a
								class="portfoliotype simple-ajax-popup"
								href="{{ route('shortInfoStore.show', $item->id) }}">{{$item->store_city}}</a> <a
								class="portfoliotype simple-ajax-popup"
								href="{{ route('shortInfoStore.show', $item->id) }}">{{$item->store_state}}</a> <a
								class="portfoliotype simple-ajax-popup"
								href="{{ route('shortInfoStore.show', $item->id) }}">{{$item->store_phone}}</a>
								@if (isset($item->social_links))
								  {!! $item->social_links->twitter !!} 
								  {!! $item->social_links->facebook !!}
								  {!! $item->social_links->instagram !!}
							    @endif
							 <a class="popup-gmaps"
								href="{{ route('googleMapStore.show', $item->id) }}"><img
								src="img/0-8132_map-marker-icon-png.png" height="40" width="40" /></a>
						</header>
					</article>
					@endforeach
				</div>
				<!-- .grid -->
				<nav class="pagination">{{ $storeList->links() }}</nav>
				<br />
			</main>
			<!-- #main -->
		</div>
		<!-- #primary -->
	</div>
	<!-- #content -->
</div>
<!-- .container -->
@endsection
