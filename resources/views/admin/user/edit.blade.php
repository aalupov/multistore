@extends('layouts.admin.main') 
@section('content')

    <!-- Main content -->
    <div class="content">
     @include('includes.error')
     @include('includes.success')

                   <form method="post" action="{{ route('adminUsers.update', $id) }}" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('User Name *') }}</label>

                            <div class="col-md-6">
                              @if($errors->any())
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>                         
                              @else
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $userInfo->name }}" required autocomplete="name" autofocus>                         
                              @endif                          
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                                                                        
                                                
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail *') }}</label>

                            <div class="col-md-6">
                              @if($errors->any())
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                              @else
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $userInfo->email }}" required autocomplete="email">
                              @endif                              
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" autocomplete="new-password">
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