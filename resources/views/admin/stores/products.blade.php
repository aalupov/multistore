@extends('layouts.admin.store') 
@section('content')

    <!-- Main content -->
    <div class="content">
     @include('includes.error')
     @include('includes.success')
    <!-- SEARCH FORM -->
      <form method="get" action="{{ route('findProductsStorePanel') }}" class="form-inline ml-3" name="find_product" id="find_product">
         @csrf
         {{ method_field('GET') }}
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" name="find_product" type="search" placeholder="Search Product" aria-label="Search">
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
      <th scope="col"></th>
      <th scope="col">Name</th>
      <th scope="col">Sku</th>      
      <th scope="col">Regular Price</th>
      <th scope="col">Sale Price</th>
      <th scope="col">Quantity</th>      
      <th scope="col">Type</th>
      <th scope="col">Categories</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
   @foreach($products as $product)
    <tr>
      <th scope="row">{{ $product->id }}</th>
      @if(isset($product->product_picture))
        <td><img src="/upload/product/{{ $product->product_picture }}" width="50" height="50"></td>
      @else
        <td></td>  
      @endif  
      <td>{{ $product->product_title }}</td>
      <td>{{ $product->product_sku }}</td> 
      <td>{{ $product->product_regular_price }}</td>     
      <td>{{ $product->product_sale_price }}</td>
      <td>{{ $product->product_quantity }}</td>
      <td>{{ $product->product_type }}</td>
      <td>
        @foreach($product->store_categories_products as $category)
          {{ $category->category_name }},
        @endforeach  
      </td>
	  <td data-th="product_edit">
           <a href="{{ route( 'adminStorePanelProduct.edit', $product->id ) }}">
			  <button type="submit" class="btn btn-secondary">Edit</button>
		   </a>
	  </td>  									
	  <td data-th="product_remove">
		  <form action="{{ route( 'adminStorePanelProduct.destroy', $product->id ) }}" method="POST">
		   @csrf
		   {{ method_field('DELETE') }}
			 <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Remove</button>
		   </form>  
	  </td>      
    </tr>
   @endforeach
  </tbody>
</table>
<table id="add_product" class="table table-hover table-condensed">
	<tfoot>
		<tr>
			<td><a href="{{ route('adminStorePanelProduct.create') }}"><button type="button"
					class="btn btn-success btn-lg">Add Product</button></a></td>
				<td colspan="4" class="hidden-xs"></td>
		</tr>
	</tfoot>
</table>
    {{ $products->links() }}
    </div>
    <!-- /.content -->


@endsection