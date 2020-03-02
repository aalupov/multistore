@extends('layouts.admin.store') 
@section('content')

    <!-- Main content -->
    <div class="content">
     @include('includes.error')
     @include('includes.success')

                   <form method="post" action="{{ route('adminStorePanelProduct.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="product_title" class="col-md-4 col-form-label text-md-right">{{ __('Product Name *') }}</label>

                            <div class="col-md-6">
                               <input id="product_title" type="text" class="form-control @error('product_title') is-invalid @enderror" name="product_title" value="{{ old('product_title') }}" required autocomplete="product_title" autofocus>                         

                                @error('product_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>   
                        
                        <div class="form-group row">
                            <label for="product_description" class="col-md-4 col-form-label text-md-right">{{ __('Product Description') }}</label>

                            <div class="col-md-6">
                                  <textarea class="form-control @error('product_description') is-invalid @enderror" aria-label="product_description" name="product_description" id="product_description" autocomplete="product_description" autofocus>{{ old('product_description') }}</textarea>
                                @error('store_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                                           
                        
                        <div class="form-group row">
                            <label for="product_regular_price" class="col-md-4 col-form-label text-md-right">{{ __('Regular Price *') }}</label>

                            <div class="col-md-6">
                               <input id="product_regular_price" type="text" class="form-control @error('product_regular_price') is-invalid @enderror" name="product_regular_price" value="{{ old('product_regular_price') }}" required autocomplete="product_regular_price" autofocus>                         

                                @error('product_regular_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>   

                        <div class="form-group row">
                            <label for="product_sale_price" class="col-md-4 col-form-label text-md-right">{{ __('Sale Price') }}</label>

                            <div class="col-md-6">
                               <input id="product_sale_price" type="text" class="form-control @error('product_sale_price') is-invalid @enderror" name="product_sale_price" value="{{ old('product_sale_price') }}" autocomplete="product_sale_price" autofocus>                         

                                @error('product_sale_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>   
                        
                        <div class="form-group row">
                            <label for="product_quantity" class="col-md-4 col-form-label text-md-right">{{ __('Product Quantity') }}</label>

                            <div class="col-md-6">
                               <input id="product_quantity" type="number" class="form-control @error('product_quantity') is-invalid @enderror" name="product_quantity" value="{{ old('product_quantity') }}" autocomplete="product_quantity" autofocus>                         

                                @error('product_quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                          

                        <div class="form-group row">
                            <label for="product_type" class="col-md-4 col-form-label text-md-right">{{ __('Product Type *') }}</label>

                            <div class="col-md-6">
                                 <select name="product_type" value="{{ old('product_type') }}" class="form-control @error('product_type') is-invalid @enderror">
                                   <option value="simple">Simple</option>
                                   <option value="variable">Variable</option>
                                   <option value="virtual">Virtual</option>
                                 </select>
                                 
                                @error('product_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 
                        
                        <div class="form-group row">
                            <label for="product_categories" class="col-md-4 col-form-label text-md-right">{{ __('Product Categories *') }}</label>

                            <div class="col-md-6">
                                 <select name="product_categories[]" class="form-control" requered multiple>
                                  @if(isset($sortedCategories['parents']))
                                    @foreach($sortedCategories['parents'] as $parent)
                                     <option value="" disabled>{{ $parent['category_name'] }}</option>
                                       @if(isset($sortedCategories['childrens'][$parent['category_id']]))
                                         @foreach($sortedCategories['childrens'][$parent['category_id']] as $kid)
                                           <option value="{{ $kid['category_id'] }}">-- {{ $kid['category_name'] }}</option>
                                         @endforeach
                                       @endif 
                                     @endforeach
                                   @endif 
                                 </select>
                            </div>
                        </div>                         

                        <div class="form-group row">
                            <label for="product_picture" class="col-md-4 col-form-label text-md-right">{{ __('Product Image (max s. 2Mb)') }}</label>

                            <div class="col-md-6">
                               <input id="product_picture" type="file" class="form-control @error('product_picture') is-invalid @enderror" name="product_picture" value="{{ old('product_picture') }}" autocomplete="product_picture" autofocus>                         

                                @error('product_picture')
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
                               <a href="{{ route('adminStorePanelProduct.show', $id) }}">
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