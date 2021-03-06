<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>

    @include('includes.fonts')
    @include('includes.styles')
    @include('includes.scripts')
    
</head>
<body class="home page page-template page-template-template-portfolio page-template-template-portfolio-php archive post-type-archive post-type-archive-product woocommerce woocommerce-page">
@include('includes.page')
</body>
</html>