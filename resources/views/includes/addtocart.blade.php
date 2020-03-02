				           <form action="{{ route('addToCartAction') }}" class="cart" method="post" enctype='multipart/form-data'>
							 @csrf
							    <input id="product_id" name="product_id" type="hidden" value="{{$item->id}}">
							    <input id="store_id" name="store_id" type="hidden" value="{{$item->store_id}}">
							    <input id="store_title" name="store_title" type="hidden" value="{{$item->store_title}}">
							    <input id="quantity" name="quantity" type="hidden" value="1">
								<button type="submit" name="fast_add_to_cart" value="cart"
									class="button">Add to cart</button>
							</form>
