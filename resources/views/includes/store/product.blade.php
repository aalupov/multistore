
<!-- #masthead -->
<div id="content" class="site-content">
    @include('includes.error')
    @include('includes.success')
	<div id="primary" class="content-area column full">
		<main id="main" class="site-main" role="main">
			<div id="container">
				<div id="content" role="main">
					<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">
						<a href="{{ url('/') }}">Home</a> / {{$products->product_title}}
					</nav>
					<div itemscope itemtype="http://schema.org/Product" class="product">
						<div class="images">
							<a href="" itemprop="image" class="woocommerce-main-image zoom"
								title="" data-rel="prettyPhoto"> <img
								src="/upload/product/{{$products->product_picture}}" alt=""></img></a>
						</div>
						<div class="summary entry-summary">
							<h1 itemprop="name" class="product_title entry-title">{{$products->product_title}}</h1>
							<div class="woocommerce-product-rating"
								itemprop="aggregateRating" itemscope
								itemtype="http://schema.org/AggregateRating">
								  <i class="fa fa-star"></i>
								  @for ($i = 2; $i <= $ratingOfProduct; $i++)
								     <i class="fa fa-star"></i> 
                                   @endfor
                               
									 <a href="#reviews"
									class="woocommerce-review-link" rel="nofollow">(<span
									itemprop="reviewCount" class="count">{{$reviews->count()}}</span> customer reviews)
								</a>
							</div>
							<div class="sku">
							   <span>SKU: {{$products->product_sku}}</span>
							</div>
							<br>
							<div itemprop="offers" itemscope
								itemtype="http://schema.org/Offer">
								<p class="price">
									@if (!empty($products->product_sale_price)) <span
										class="amount"><strike>{{$products->product_regular_price}}</strike>
									</span> <span class="amount">{{$products->product_sale_price}}
									</span> @else <span class="amount">{{$products->product_regular_price}}
									</span> @endif
								</p>
							</div>
							<br>
							<div itemprop="description">
								<p>{{$products->product_description}}</p>
							</div>
							@if ($products->product_quantity !=0 )
							<form action="{{ route('addToCartAction') }}" class="cart" method="post" enctype='multipart/form-data'>
							@csrf
							 <input id="product_id" name="product_id" type="hidden" value="{{$products->id}}">
							 <input id="store_id" name="store_id" type="hidden" value="{{$storeInfo->id}}">
							 <input id="store_title" name="store_title" type="hidden" value="{{$storeInfo->store_title}}">
							 @if ($products->product_type == 'variable' )
						    	@foreach($attributes as $items)
							      <div class="attributes" name="{{$items->attribute_name}}" id="{{$items->id}}">
							     	<font color="red">{{$items->attribute_name}} *</font>
							     	<input id="attribute_names" name="attribute_names[]" type="hidden" value="{{$items->attribute_name}}">
							     	<select id="{{$items->attribute_name}}" name="{{$items->attribute_name}}">
             				        	@foreach($items->values_attributes as $item)
			     				        	<option value="{{$item->attribute_value}}">{{$item->attribute_value}}</option>
							        	@endforeach	
							     	</select>
						          </div>
							    @endforeach	
							    <br>
							  @endif							
								<div class="quantity">
									<input type="number" step="1" min="1" max="" name="quantity"
										value="1" title="Qty" class="input-text qty text" size="4" />
								</div>
								<button type="submit"
									class="single_add_to_cart_button button alt">Add to cart</button>
							</form>
							@else
							<font color="red">Out of stock</font>
							@endif
							<div class="product_meta">
								<span class="posted_in">Categories:
								  @foreach($categoryNamesOfProduct as $key => $item)
								     <a href="/category/{{$key}}" rel="tag">{{$item}}</a>/
								   @endforeach
								</span>
							</div>
						</div>				
						<!-- .summary -->
						<div class="woocommerce-tabs wc-tabs-wrapper">
							<div class="panel entry-content wc-tab" id="tab-description">
							<div class="panel entry-content wc-tab" id="tab-reviews">
								<div id="reviews">	
									<div id="comments">
										<h2>{{$reviews->count()}} Reviews for {{$products->product_title}}</h2>
										<ol class="commentlist">
										    <!-- #comment-## -->
										    @foreach($reviews as $item)
											<li itemprop="review" itemscope
												itemtype="http://schema.org/Review" class="comment">
												<div id="comment-3" class="comment_container">
													<div class="comment-text">
														<p class="meta">
															<strong itemprop="author">{{$item->customer_name}}</strong> &ndash;
															<time itemprop="datePublished"
																datetime="{{$item->updated_at}}">{{$item->updated_at}}</time>
															:
														</p>
														<div itemprop="description" class="description">
															<p>{{$item->review}}</p>
														</div>
													</div>
												</div>
											</li>	
											@endforeach										
											<!-- #comment-## -->
											<ul class="page-numbers">{{ $reviews->links() }}</ul>
										</ol>
									</div>
									<div id="review_form_wrapper">
										<div id="review_form">
											<div id="respond" class="comment-respond">
												<h3 style="margin-bottom: 10px;" id="reply-title"
													class="comment-reply-title">
													Add a review <small><a rel="nofollow"
														id="cancel-comment-reply-link"
														href="/demo-moschino/product/woo-logo-2/#respond"
														style="display: none;">Cancel reply</a></small>
												</h3>
												<form action="{{ route('productPage.store') }}" method="post" id="commentform"
													class="comment-form" novalidate>
													@csrf
													<input id="store_id" name="store_id" type="hidden" value="{{$storeInfo->id}}">
													<p class="comment-form-rating">
														<label for="rating">Your Rating</label> <select
															name="rating" id="rating">
															<!-- <option value="">Rate&hellip;</option> -->
															<option value="50">Perfect</option>
															<option value="40">Good</option>
															<option value="30">Average</option>
															<option value="20">Not that bad</option>
															<option value="10">Very Poor</option>
														</select>
													</p>
													<p class="comment-form-comment">
														<label for="comment">Your Review</label>
														<textarea id="comment" name="comment" cols="45" rows="8"
															aria-required="true">{{ old('comment') }}</textarea>
													</p>
													<p class="comment-form-author">
														<label for="author">Name <span class="required">*</span></label><input
															id="author" name="author" type="text" value="{{ old('author') }}" size="30"
															aria-required="true" />
													</p>
													<p class="comment-form-email">
														<label for="email">Email <span class="required">*</span></label><input
															id="email" name="email" type="text" value="{{ old('email') }}" size="30"
															aria-required="true" />
													</p>
													<p class="form-submit">
														<input name="submit" type="submit" id="submit"
															class="submit" value="Submit" /><input type='hidden'
															name='comment_product_ID' value='{{$products->id}}' id='comment_product_ID' />
													</p>
												</form>
											</div>
											<!-- #respond -->
										</div>
									</div>									
									<div class="clear"></div>
								</div>
							</div>
						</div>
						<div class="related products">
							<h2>Related Products</h2>
							<ul class="products">
							    @foreach($relatedProducts as $item) 
								<li class="product"><a href="{{ route('productPage.show', $item->id) }}"> 
						         <div> 
							        <i class="fa fa-star fa-lg"></i>
		                             @for ($i = 2; $i <= $item->rating; $i++)
							           <i class="fa fa-star fa-lg"></i>
							         @endfor
							     </div>  
								@if (!empty($item->product_sale_price)) 
								  <span class="onsale">Sale!</span> 
								@endif
										<img src="/upload/product/{{$item->product_picture}}" alt="">
										</img>
										<h3>{{$item->product_title}}</h3> 
										<span class="price">
									    											
						                	@if (!empty($item->product_sale_price))
													<span class="amount"><strike>{{$item->product_regular_price}}</strike></span> 
													<span class="amount">{{$item->product_sale_price}}</span>
	                      					@else
					                       		  <span class="amount">{{$item->product_regular_price}}</span>
					                        @endif 	
											
										</span>
								</a> 
								 @include('includes.addtocart')</li>
                                 @endforeach
							</ul>
							<ul class="page-numbers">{{ $relatedProducts->links() }}
				           </ul>
						</div>
					</div>
				</div>
			</div>
		</main>
		<!-- #main -->
	</div>
	<!-- #primary -->
</div>
<!-- #content -->