<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$storeInfo->store_title}} - {{$products->product_title}}</title>

    @include('includes.fonts')
    @include('includes.styles')
    @include('includes.scripts')
    
</head>
<body class="single single-product woocommerce woocommerce-page">
@include('includes.page')
</body>
</html>