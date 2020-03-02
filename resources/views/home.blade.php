@extends('layouts.dashboard') @if (session('status'))
<div class="alert alert-success" role="alert">{{ session('status') }}</div>
@endif @section('content')
<div class="container">
	<!-- #masthead -->
	<header id="masthead" class="site-header">
		<div class="site-branding">
			<h1 class="site-title">Dashboard</h1>
		</div>
		@include('includes.user.navbar')
	</header>
	<div id="content" class="site-content">
		@include('includes.error') @include('includes.success')
		<h3>Congratulation! You are log in</h3>
		<br>
		
		@if($adminStatus)
		 <h4>You are available to go to <a href="{{ route('adminMainPanel.index') }}">Admin panel</a></h4>
		@endif
		
		@if($adminStoreStatus)
		 <h4>You are available to go to <a href="{{ route('homeStorePanel.show', $checkStoreAdmin->store_id) }}">Admin Store panel</a></h4>
		@endif
	</div>
</div>
@endsection
