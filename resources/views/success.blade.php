@extends('layouts.app') @section('content')
<div class="container">
	<!-- #masthead -->
	<header id="masthead" class="site-header">
		<div class="site-branding">
			<h1 class="site-title">Sussess Page</h1>
		</div>
	</header>
	<div id="content" class="site-content">@include('includes.error')
		@include('includes.success')</div>
</div>
@endsection
