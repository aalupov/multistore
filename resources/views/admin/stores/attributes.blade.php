@extends('layouts.admin.store') 
@section('content')

    <!-- Main content -->
   <div class="content">
     @include('includes.error')
     @include('includes.success')
    <div class="container">
    <form method="post" action="{{ route('adminStorePanelAttributes.update', $id) }}" enctype="multipart/form-data">
    @csrf
    {{ method_field('PUT') }}   
  <div class="row">
    <div class="col">
     <div class="input-group mb-3">
       <div class="input-group-prepend">
         <span class="input-group-text" id="inputGroup-sizing-default">New Attribute</span>
       </div>
        <input type="text" class="form-control" name="new_attribute_name" value="{{ old('new_attribute_name') }}" aria-describedby="inputGroup-sizing-default">
     </div>
    </div> 
    <strong>for</strong>
    <div class="col">
     <div class="input-group mb-3">
       <select class="custom-select" id="selected_product" name="selected_product">
         @foreach($products as $item)
             <option value="{{ $item->id }}">{{ $item->id }}-{{ $item->product_title }}</option>
         @endforeach  
       </select>
    </div>
  </div>
 </div>
   <div class="row">
    <div class="col">
     <div class="input-group mb-3">
       <div class="input-group-prepend">
         <span class="input-group-text" id="inputGroup-sizing-default">Attribute Value</span>
       </div>
        <input type="text" class="form-control" name="attribute_value" value="{{ old('attribute_value') }}" aria-describedby="inputGroup-sizing-default">
     </div>
    </div>    
    <strong>for</strong>
    <div class="col">
     <div class="input-group mb-3">
       <select class="custom-select" id="selected_attribute" name="selected_attribute">
         @foreach($attributes as $item)
             <option value="{{ $item->id }}">{{ $item->attribute_name }}-{{ $item->product_id }}-{{ $item->product_title }}</option>
         @endforeach  
       </select>
       <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit">Save</button>
       </div>
    </div>
  </div>
 </div>
  </form>
</div>
<hr>
   <div class="container">
      <form method="post" action="{{ route('adminStorePanelAttributes.update', $id) }}" enctype="multipart/form-data">
      @csrf
      {{ method_field('PUT') }}  
    <div class="row">
    <div class="col">
     <div class="input-group mb-3">
       <select class="custom-select" id="attribute_to_remove" name="attribute_to_remove">
         @foreach($attributes as $item)
             <option value="{{ $item->id }}">{{ $item->attribute_name }}-{{ $item->product_id }}-{{ $item->product_title }}</option>
         @endforeach  
       </select>
       <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit">Remove Attribute</button>
       </div>
    </div>
  </div>
 </div>
    </form>
  </div>  
  <hr>
  <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Product Name</th>
      <th scope="col">Attribute</th>
      <th scope="col">Values</th>      
    </tr>
  </thead>
  <tbody>
   @foreach($paginatedAttributes as $item)
    <tr> 
      <td>{{ $item->product_id }} - {{ $item->product_title }}</td>
      <td>{{ $item->attribute_name }}</td> 
      <td>
        @foreach($item->values_attributes as $value)
          <p>{{ $value->attribute_value }} <a href="{{ route('adminStorePanelAttributes.edit', $value->id) }}" onclick="return confirm('Are you sure?')"><span class="badge badge-pill badge-danger">x</span></a></p>
        @endforeach  
      </td>      
    </tr>
   @endforeach
  </tbody>
</table>
{{ $paginatedAttributes->links() }}
 </div>
    <!-- /.content -->

@endsection