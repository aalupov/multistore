@extends('layouts.app') @section('content')
<div class="container">
	<!-- #masthead -->
	<header id="masthead" class="site-header">
		<div class="site-branding">
			<h1 class="site-title">Add a Buisness Page</h1>
		</div>
	</header>
	<div id="content" class="site-content">
		@include('includes.navbar')
		@include('includes.error')
		@include('includes.success')<br>
		<div class="container">
		               <form method="post" action="{{ route('addBuisnessSend') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="store_title" class="col-md-4 col-form-label text-md-right">{{ __('Store Name *') }}</label>

                            <div class="col-md-6">
                               <input id="store_title" type="text" class="form-control @error('store_title') is-invalid @enderror" name="store_title" value="{{ old('store_title') }}" required autocomplete="store_title" autofocus>                         

                                @error('store_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>   
                        
                        <div class="form-group row">
                            <label for="store_description" class="col-md-4 col-form-label text-md-right">{{ __('Store Description *') }}</label>

                            <div class="col-md-6">
                                  <textarea class="form-control @error('store_description') is-invalid @enderror" aria-label="store_description" name="store_description" id="store_description" autocomplete="store_description" autofocus>{{ old('store_description') }}</textarea>
                                @error('store_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                                           
                        
                        <div class="form-group row">
                            <label for="store_email" class="col-md-4 col-form-label text-md-right">{{ __('Store E-Mail *') }}</label>

                            <div class="col-md-6">
                                <input id="store_email" type="email" class="form-control @error('store_email') is-invalid @enderror" name="store_email" value="{{ old('store_email') }}" required autocomplete="store_email">

                                @error('store_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="store_phone" class="col-md-4 col-form-label text-md-right">{{ __('Store Phone *') }}</label>

                            <div class="col-md-6">
                               <input id="store_phone" type="number" class="form-control @error('store_phone') is-invalid @enderror" name="store_phone" value="{{ old('store_phone') }}" required autocomplete="store_phone" autofocus>                         

                                @error('store_phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>  
                        
                        <div class="form-group row">
                            <label for="store_address" class="col-md-4 col-form-label text-md-right">{{ __('Store Address *') }}</label>

                            <div class="col-md-6">
                               <input id="store_address" type="text" class="form-control @error('store_address') is-invalid @enderror" name="store_address" value="{{ old('store_address') }}" required autocomplete="store_address" autofocus>                         

                                @error('store_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="store_city" class="col-md-4 col-form-label text-md-right">{{ __('Store City *') }}</label>

                            <div class="col-md-6">
                               <input id="store_city" type="text" class="form-control @error('store_city') is-invalid @enderror" name="store_city" value="{{ old('store_city') }}" required autocomplete="store_city" autofocus>                         

                                @error('store_city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="store_country" class="col-md-4 col-form-label text-md-right">{{ __('Store Country *') }}</label>

                            <div class="col-md-6">
                                 <select name="store_country" value="{{ old('store_country') }}" class="form-control @error('store_country') is-invalid @enderror">
                                   <option value="USA">USA</option>
                                 </select>
                                 
                                @error('store_country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 
 
                        <div class="form-group row">
                            <label for="store_state" class="col-md-4 col-form-label text-md-right">{{ __('Store State *') }}</label>

                            <div class="col-md-6">
                               <input id="store_state" type="text" class="form-control @error('store_state') is-invalid @enderror" name="store_state" value="{{ old('store_state') }}" required autocomplete="store_state" autofocus>                         

                                @error('store_state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="store_zip" class="col-md-4 col-form-label text-md-right">{{ __('Store Zip Code *') }}</label>

                            <div class="col-md-6">
                               <input id="store_zip" type="text" class="form-control @error('store_zip') is-invalid @enderror" name="store_zip" value="{{ old('store_zip') }}" required autocomplete="store_zip" autofocus>                         

                                @error('store_zip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="store_picture" class="col-md-4 col-form-label text-md-right">{{ __('Store Image (max s. 2Mb)') }}</label>

                            <div class="col-md-6">
                               <input id="store_picture" type="file" class="form-control @error('store_picture') is-invalid @enderror" name="store_picture" value="{{ old('store_picture') }}" autocomplete="store_picture" autofocus>                         

                                @error('store_picture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
  
                        <div class="form-group row">
                            <label for="store_lat" class="col-md-4 col-form-label text-md-right">{{ __('Store Latitude *') }}</label>

                            <div class="col-md-6">
                               <input id="store_lat" type="text" class="form-control @error('store_lat') is-invalid @enderror" name="store_lat" value="{{ old('store_lat') }}" required autocomplete="store_lat" autofocus>                         

                                @error('store_lat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
 
                        <div class="form-group row">
                            <label for="store_lon" class="col-md-4 col-form-label text-md-right">{{ __('Store Longitude *') }}</label>

                            <div class="col-md-6">
                               <input id="store_lon" type="text" class="form-control @error('store_lon') is-invalid @enderror" name="store_lon" value="{{ old('store_lon') }}" required autocomplete="store_lon" autofocus>                         

                                @error('store_lon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                                                                                                                                           

                        <div class="form-group row">
                            <label for="store_comment" class="col-md-4 col-form-label text-md-right">{{ __('Leave your comment') }}</label>

                            <div class="col-md-6">
                                  <textarea class="form-control @error('store_comment') is-invalid @enderror" aria-label="store_comment" name="store_comment" id="store_comment" autocomplete="store_comment" autofocus>{{ old('store_comment') }}</textarea>
                                @error('store_comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>  
                                                                                                                                                                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Send') }}
                                </button>                                
                            </div>
                         </div>
             </form>
          </div>
	</div>
</div>
@endsection