@extends('layouts.admin.main') 
@section('content')

    <!-- Main content -->
    <div class="content">
     @include('includes.error')
     @include('includes.success')
    <!-- SEARCH FORM -->
      <form method="get" action="{{ route('findUserAdminPanel') }}" class="form-inline ml-3" name="find_user" id="find_user">
         @csrf
         {{ method_field('GET') }}
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" name="find_user" type="search" placeholder="Search User" aria-label="Search">
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
      <th scope="col">Store Admin</th>      
      <th scope="col">General Admin</th>
      <th scope="col">Email</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
   @foreach($users as $user)
    <tr>
      <th scope="row">{{ $user->id }}</th>
      <td>{{ $user->name }}</td>
      @if($user->is_store_admin)
        <td>YES - <a href="{{ route('adminStores.show', $user->store_id) }}">Store View</a></td>
      @else
        <td>NO</td>
      @endif  
      @if($user->is_general_admin)
        <td>YES</td>
      @else
        <td>NO</td>
      @endif         
      <td>{{ $user->email }}</td>     
	  <td data-th="user_edit">
           <a href="{{ route( 'adminUsers.edit', $user->id ) }}">
			  <button type="submit" class="btn btn-secondary">Edit</button>
		   </a>
	  </td>  									
	  <td data-th="user_remove">
		  <form action="{{ route( 'adminUsers.destroy', $user->id ) }}" method="POST">
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
			<td><a href="{{ route('adminUsers.create') }}"><button type="button"
					class="btn btn-success btn-lg">Add User</button></a></td>
				<td colspan="4" class="hidden-xs"></td>
		</tr>
	</tfoot>
</table>
  {{ $users->links() }}
    </div>
    <!-- /.content -->

@endsection