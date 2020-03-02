@extends('layouts.store') @section('content')
<div class="container">
	@include('includes.store.header') @include('includes.store.descrp')
	@include('includes.store.navbar') <br>
	<h2 class="entry-title">Latest Products</h2>

	@include('includes.store.products')
</div>
@endsection
