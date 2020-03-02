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
	@include('includes.products')
</div>
<!-- .container -->
@endsection
