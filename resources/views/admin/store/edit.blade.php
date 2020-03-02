@extends('layouts.admin.main') 
@section('content')

    <!-- Main content -->
    <div class="content">
     @include('includes.error')
     @include('includes.success')

                   <form method="post" action="{{ route('adminStores.update', $id) }}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group row">
                            <label for="store_title" class="col-md-4 col-form-label text-md-right">{{ __('Store Name *') }}</label>

                            <div class="col-md-6">
                              @if($errors->any())
                               <input id="store_title" type="text" class="form-control @error('store_title') is-invalid @enderror" name="store_title" value="{{ old('store_title') }}" required autocomplete="store_title" autofocus>                         
                              @else
                                <input id="store_title" type="text" class="form-control @error('store_title') is-invalid @enderror" name="store_title" value="{{ $storeInfo->store_title }}" required autocomplete="store_title" autofocus>                         
                              @endif
                                @error('store_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>   
                        
                        <div class="form-group row">
                            <label for="store_description" class="col-md-4 col-form-label text-md-right">{{ __('Store Description') }}</label>

                            <div class="col-md-6">
                                @if($errors->any())
                                  <textarea class="form-control @error('store_description') is-invalid @enderror" aria-label="store_description" name="store_description" id="store_description" autocomplete="store_description" autofocus>{{ old('store_description') }}</textarea>
                                @else
                                   <textarea class="form-control @error('store_description') is-invalid @enderror" aria-label="store_description" name="store_description" id="store_description" autocomplete="store_description" autofocus>{{ $storeInfo->store_description }}</textarea>
                                @endif
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
                               @if($errors->any())
                                 <input id="store_email" type="email" class="form-control @error('store_email') is-invalid @enderror" name="store_email" value="{{ old('store_email') }}" required autocomplete="store_email">
                               @else
                                 <input id="store_email" type="email" class="form-control @error('store_email') is-invalid @enderror" name="store_email" value="{{ $storeInfo->store_email }}" required autocomplete="store_email">
                               @endif
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
                              @if($errors->any())
                                <input id="store_phone" type="number" class="form-control @error('store_phone') is-invalid @enderror" name="store_phone" value="{{ old('store_phone') }}" required autocomplete="store_phone" autofocus>                         
                              @else
                                  <input id="store_phone" type="number" class="form-control @error('store_phone') is-invalid @enderror" name="store_phone" value="{{ $storeInfo->store_phone }}" required autocomplete="store_phone" autofocus>                         
                              @endif                           
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
                              @if($errors->any())
                                <input id="store_address" type="text" class="form-control @error('store_address') is-invalid @enderror" name="store_address" value="{{ old('store_address') }}" required autocomplete="store_address" autofocus>                         
                              @else
                                <input id="store_address" type="text" class="form-control @error('store_address') is-invalid @enderror" name="store_address" value="{{ $storeInfo->store_address }}" required autocomplete="store_address" autofocus>                         
                              @endif                              
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
                             @if($errors->any())
                               <input id="store_city" type="text" class="form-control @error('store_city') is-invalid @enderror" name="store_city" value="{{ old('store_city') }}" required autocomplete="store_city" autofocus>                         
                             @else
                               <input id="store_city" type="text" class="form-control @error('store_city') is-invalid @enderror" name="store_city" value="{{ $storeInfo->store_city }}" required autocomplete="store_city" autofocus>                         
                             @endif  
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
                              @if($errors->any())
                                 <select name="store_country" value="{{ old('store_country') }}" class="form-control @error('store_country') is-invalid @enderror">
                                   <option value="USA">USA</option>
                                 </select>
                              @else
                                 <select name="store_country" value="{{ $storeInfo->store_country }}" class="form-control @error('store_country') is-invalid @enderror">
                                   <option value="USA">USA</option>
                                 </select>
                              @endif                                   
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
                             @if($errors->any())
                               <input id="store_state" type="text" class="form-control @error('store_state') is-invalid @enderror" name="store_state" value="{{ old('store_state') }}" required autocomplete="store_state" autofocus>                         
                             @else
                               <input id="store_state" type="text" class="form-control @error('store_state') is-invalid @enderror" name="store_state" value="{{ $storeInfo->store_state }}" required autocomplete="store_state" autofocus>                         
                             @endif                         
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
                              @if($errors->any())
                               <input id="store_zip" type="text" class="form-control @error('store_zip') is-invalid @enderror" name="store_zip" value="{{ old('store_zip') }}" required autocomplete="store_zip" autofocus>                         
                              @else
                               <input id="store_zip" type="text" class="form-control @error('store_zip') is-invalid @enderror" name="store_zip" value="{{ $storeInfo->store_zip }}" required autocomplete="store_zip" autofocus>                         
                              @endif                             
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
                             @if($errors->any())
                               <input id="store_lat" type="text" class="form-control @error('store_lat') is-invalid @enderror" name="store_lat" value="{{ old('store_lat') }}" required autocomplete="store_lat" autofocus>                         
                             @else
                                <input id="store_lat" type="text" class="form-control @error('store_lat') is-invalid @enderror" name="store_lat" value="{{ $storeInfo->store_lat }}" required autocomplete="store_lat" autofocus>                         
                             @endif                           
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
                              @if($errors->any())
                                <input id="store_lon" type="text" class="form-control @error('store_lon') is-invalid @enderror" name="store_lon" value="{{ old('store_lon') }}" required autocomplete="store_lon" autofocus>                         
                              @else
                                <input id="store_lon" type="text" class="form-control @error('store_lon') is-invalid @enderror" name="store_lon" value="{{ $storeInfo->store_lon }}" required autocomplete="store_lon" autofocus>                         
                              @endif
                                @error('store_lon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                       
                                                                                              
                        <div class="form-group row">
                            <label for="store_is_activated" class="col-md-4 col-form-label text-md-right">{{ __('Store Active?') }}</label>

                            <div class="col-md-6">
                               <input id="store_is_activated" type="checkbox" class="form-control @error('store_is_activated') is-invalid @enderror" name="store_is_activated" value="true" autocomplete="store_is_activated" autofocus checked>                         

                                @error('store_is_activated')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                          
                                                                                                                                                
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Save') }}
                                </button>                                
                            </div>
                         </div>   <br>
                         <div class="form-group row mb-0">   
                             <div class="col-md-6 offset-md-4">
                               <a href="{{ route('adminStores.index') }}">
                                <button type="button" class="btn btn-secondary btn-block">
                                    {{ __('Cancel') }}
                                </button> 
                               </a>   
                              </div>                                                           
                        </div>
               </form>
    <!-- /.content -->
</div>
@endsection