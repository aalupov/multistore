@extends('layouts.admin.main') 
@section('content')

    <!-- Main content -->
    <div class="content">
     @include('includes.error')
     @include('includes.success')
<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Google Api Key
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
       <form id="find_product_form" action="{{ route('adminSettings.store') }}" method="POST">
       @csrf
       <div class="input-group mb-3">
           <div class="form-group">
             <label for="country_location">Country of location @if(isset($apiKeyAndCountry)) - {{ $apiKeyAndCountry->country_location }} @endif</label>
               <select class="form-control" id="country_location" name="country_location">
                 <option>US</option>
                 <option>RU</option>
                 <option>FR</option>
              </select>
            </div>
        </div>
         <div class="input-group mb-3">
           <div class="input-group-prepend">
             <span class="input-group-text">Api Key *</span>
           </div>
           @if(isset($apiKeyAndCountry))
            @if($errors->any())
              <input type="text" class="form-control" name="api_key" value="{{ old('api_key') }}" aria-label="api_key" aria-describedby="basic-addon1">                
            @else
              <input type="text" class="form-control" name="api_key" value="{{ $apiKeyAndCountry->google_api_keys }}" aria-label="api_key" aria-describedby="basic-addon1">     
            @endif
          @else
             <input type="text" class="form-control" name="api_key" value="{{ old('api_key') }}" aria-label="api_key" aria-describedby="basic-addon1">                  
          @endif
        </div> <br>
          <div><button type="submit" class="btn btn-primary">Save</button> </div>  
        </form>    
      </div>
    </div>
  </div>
<!--  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Countries Geo Data
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div> -->
    </div>
    <!-- /.content -->

@endsection