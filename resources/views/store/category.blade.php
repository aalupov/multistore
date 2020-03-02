@extends('layouts.category') 
@section('content')
<div class="container">
	@include('includes.store.header') 
	@include('includes.store.navbar') <br>
	<h2 class="entry-title">{{$categoryName}}</h2>

	@include('includes.store.products')
</div>
@endsection