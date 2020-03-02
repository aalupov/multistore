@extends('layouts.admin.main') 
@section('content')

    <!-- Main content -->
    <div class="content">
     @include('includes.error')
     @include('includes.success')

                   <form method="post" action="{{ route('adminUsers.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name *') }}</label>

                            <div class="col-md-6">
                               <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>                         

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                                                                    

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name *') }}</label>

                            <div class="col-md-6">
                               <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>                         

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>     
                                                
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail *') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password *') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password *') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" required autocomplete="new-password">
                            </div>
                        </div>                    

                        <div class="form-group row">
                            <label for="email_verified" class="col-md-4 col-form-label text-md-right">{{ __('Email is verified?') }}</label>

                            <div class="col-md-6">
                               <input id="email_verified" type="checkbox" class="form-control @error('email_verified') is-invalid @enderror" name="email_verified" value="true" autocomplete="email_verified" autofocus checked>                         

                                @error('store_is_activated')
                                    <span class="email_verified" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>    
                                                                                                                      
                        <div class="form-group row">
                            <label for="is_general_admin" class="col-md-4 col-form-label text-md-right">{{ __('User is General Admin?') }}</label>

                            <div class="col-md-6">
                               <input id="is_general_admin" type="checkbox" class="form-control @error('is_general_admin') is-invalid @enderror" name="is_general_admin" value="true" autocomplete="is_general_admin" autofocus>                         

                                @error('store_is_activated')
                                    <span class="is_general_admin" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                          

                         @if(isset($stores))
                        <div class="form-group row">
                            <label for="is_store_admin" class="col-md-4 col-form-label text-md-right">{{ __('User is Store Admin?') }}</label>

                            <div class="col-md-6">
                               <input id="is_store_admin" type="checkbox" class="form-control @error('is_store_admin') is-invalid @enderror" name="is_store_admin" value="true" autocomplete="is_store_admin" autofocus>                         

                                @error('store_is_activated')
                                    <span class="is_store_admin" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 
                                                                   
                        <div class="form-group row">
                            <label for="selected_store" class="col-md-4 col-form-label text-md-right">{{ __('Select Store to manage by User') }}</label>

                            <div class="col-md-6">
                                 <select name="selected_store" value="{{ old('selected_store') }}" class="form-control @error('selected_store') is-invalid @enderror">
                                  @foreach($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->id }} - {{ $store->store_title }}</option>
                                  @endforeach 
                                 </select>
                                 
                                @error('selected_store')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 
                        @endif
                                                                                                                                                                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Save') }}
                                </button>                                
                            </div>
                         </div>   <br>
                         <div class="form-group row mb-0">   
                             <div class="col-md-6 offset-md-4">
                               <a href="{{ route('adminUsers.index') }}">
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