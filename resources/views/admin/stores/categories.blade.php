@extends('layouts.admin.store') 
@section('content')

    <!-- Main content -->
   <div class="content">
     @include('includes.error')
     @include('includes.success')
    <div class="container">
    <form method="post" action="{{ route('adminStorePanelCategory.update', $id) }}" enctype="multipart/form-data">
    @csrf
    {{ method_field('PUT') }}
  <div class="row">
    <div class="col">
     <div class="input-group mb-3">
       <div class="input-group-prepend">
         <span class="input-group-text" id="inputGroup-sizing-default">New Category</span>
       </div>
        <input type="text" class="form-control" name="category_name" value="{{ old('category_name') }}" aria-describedby="inputGroup-sizing-default">
     </div>
    </div>
    <div class="col">
     <div class="input-group mb-3">
       <select class="custom-select" id="selected_parent_cat" name="selected_parent_cat">
         <option value="0" selected>Root</option>
         @foreach($categories as $item)
           @if(!isset($item->parent_id))
             <option value="{{ $item->id }}">{{ $item->category_name }}</option>
           @endif
         @endforeach  
       </select>
       <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit">Add Category</button>
       </div>
    </div>
  </div>
 </div>
 </form>
</div>
<br>

<div class="treeview">
<ul data-widget="treeview">
  @if(isset($sortedCategories['parents']))
  @foreach($sortedCategories['parents'] as $parent)
  <li class="treeview">
    <strong>{{ $parent['category_name'] }}</strong> <a href="{{ route('adminStorePanelCategory.edit', $parent['category_id']) }}" onclick="return confirm('Are you sure?')"><span class="badge badge-pill badge-danger">x</span></a>
    <ul class="treeview-menu">
      @if(isset($sortedCategories['childrens'][$parent['category_id']]))
       @foreach($sortedCategories['childrens'][$parent['category_id']] as $kid)
         <li>{{ $kid['category_name'] }} <a href="{{ route('adminStorePanelCategory.edit', $kid['category_id']) }}" onclick="return confirm('Are you sure?')"><span class="badge badge-pill badge-danger">x</span></a></li>
       @endforeach
      @endif 
    </ul>
  </li>
  @endforeach
  @endif
</ul>
</div>


    </div>
    <!-- /.content -->

@endsection