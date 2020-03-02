<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta charset="utf-8">
<link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
<link rel="stylesheet" href="{{ asset('css/store-popup-window.css') }}">
</head>
<body>
	<div class="mfp-content">
		<div class="ajax-text-and-image white-popup-block">
			<div class="ajcol">
				<img src="{{ asset('upload/store') }}/{{$storeInfo->store_picture}}" />
			</div>
			<div class="ajcol" style="line-height: 1.231;">
				<div style="padding: 1em">
					<h2>{{$storeInfo->store_title}}</h2>
					<p>{{$storeInfo->store_description}}</p>
					<ul>
						<li><b>City:</b> {{$storeInfo->store_city}}</li>
						<li><b>Phone:</b> {{$storeInfo->store_phone}}</li>
						<li><b>Email:</b> {{$storeInfo->store_email}}</li>
						<li>@if ($storeInfo->store_status) <b><font color="green">OPENED</font></b>
							@else <b><font color="red">CLOSED</font></b> @endif
						</li>
						<li><button>
								<a href="{{route('storePage.show', $storeInfo->id) }}" target="_blank">Go to
									{{$storeInfo->store_title}}</a>
							</button></li>
					</ul>
				</div>
			</div>
			@if (isset($storeInfo->social_links))
			  <div>{!! $storeInfo->social_links->twitter !!} {!! $storeInfo->social_links->facebook !!} {!! $storeInfo->social_links->instagram !!}</div>
            @endif
			<div style="clear: both; line-height: 1;"></div>
			<button title="Close (Esc)" type="button" class="mfp-close">×</button>
		</div>
	</div>
</body>
</html>