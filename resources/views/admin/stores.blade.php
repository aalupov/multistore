@extends('layouts.admin.main') 
@section('content')

    <!-- Main content -->
    <div class="content">
     @include('includes.error')
     @include('includes.success')
    <!-- SEARCH FORM -->
      <form method="get" action="{{ route('findStoreAdminPanel') }}" class="form-inline ml-3" name="find_store" id="find_store">
         @csrf
         {{ method_field('GET') }}
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" name="find_store" type="search" placeholder="Search Store" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form><br>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Active</th>
      <th scope="col">Country</th>
      <th scope="col"></th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
   @foreach($stores as $store)
    <tr>
      <th scope="row">{{ $store->id }}</th>
      <td>{{ $store->store_title }}</td>
      @if($store->store_is_activated)
        <td>YES</td>
      @else
        <td>NO</td>
      @endif     
      <td>{{ $store->store_country }}</td>
	  <td data-th="store_view">
           <a href="{{ route( 'adminStores.show', $store->id ) }}">
			  <button type="submit" class="btn btn-primary">View</button>
		   </a>
	  </td>       
	  <td data-th="store_edit">
           <a href="{{ route( 'adminStores.edit', $store->id ) }}">
			  <button type="submit" class="btn btn-secondary">Edit</button>
		   </a>
	  </td>  									
	  <td data-th="store_remove">
		  <form action="{{ route( 'adminStores.destroy', $store->id ) }}" method="POST">
		   @csrf
		   {{ method_field('DELETE') }}
			 <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Remove</button>
		   </form>  
	  </td>      
    </tr>
   @endforeach
  </tbody>
</table>
<table id="add_store" class="table table-hover table-condensed">
	<tfoot>
		<tr>
			<td><a href="{{ route('adminStores.create') }}"><button type="button"
					class="btn btn-success btn-lg">Add Store</button></a></td>
				<td colspan="4" class="hidden-xs"></td>
		</tr>
	</tfoot>
</table>
  {{ $stores->links() }}
    </div>
    <!-- /.content -->

@endsection