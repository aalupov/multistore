@extends('layouts.checkout') @section('content')
<div class="container">
	<!-- #masthead -->
	<header id="masthead" class="site-header">
		<div class="site-branding">
			<h1 class="site-title">Checkout</h1>
		</div>
	</header>
	<div id="content" class="site-content">
	    @include('includes.error')
        @include('includes.success')
		<div id="primary" class="content-area column full">
			<main id="main" class="site-main" role="main">
				<div id="container">
					<div id="content" role="main">
					@if(session('cart'))
					<form action="{{ route('placeOrder') }}" class="checkout" name="checkout" method="post" enctype='multipart/form-data'>
					@csrf
					<hr>
					<div class="wpcmsdev-columns">
						<div class="column column-width-one-half">
							<p>
							    <strong>Billing Address</strong>
							</p>
						    @guest	
							  <?php $address_type = 'billing' ?>
                              @include('includes.address', ['address_type' => $address_type])  
                            @endguest
                            @auth
                                <div class="form-group">
                                  <label for="billing_address">Select address</label>
                                  <select class="form-control" id="billing_address" name="billing">
                                    @foreach($addresses as $item)
                                        <option>{{ $item->id  }}|{{ $item->first_name  }}|{{ $item->last_name  }}|{{ $item->email  }}|{{ $item->phone  }}|{{ $item->city  }}|{{ $item->zip_code  }}|{{ $item->address  }}|{{ $item->state  }}|{{ $item->country  }}</option>                                    
                                    @endforeach            
                                   </select>
                                  </div>
                            <p>
							    <a href="{{ route('addressUser.create') }}"><button type="button" class="btn btn-secondary">Create New Address</button></a>
							</p>  
                            @endauth                            
						</div>
						<div class="column column-width-one-half">
						  @if (!$virtual)
						   <input name="virtual" class="virtual" type="hidden" value="0"/>
			              @if (old('answer') == 1)
			                <strong>Shipping address is same</strong>  
			                     <input name="answer" class="addr_same" type="hidden" value="1"/> 
			               @else 
							    <fieldset id="question">
                                <legend><strong>Shipping address is same?</strong></legend>
                                  <label for="answerYes">Yes</label>
                                   <input name="answer" class="addr_same" type="radio" value="1"/>
                                  <label for="answerNo">No</label>
                                   <input name="answer" class="addr_same" type="radio" value="0" checked/>
                                </fieldset>
                              
                                <div class="subQuestion">
                                 @guest	
                                   <?php $address_type = 'shipping' ?>
                                   @include('includes.address', ['address_type' => $address_type])    
                                 @endguest     
                                 @auth
                                  <div class="form-group">
                                    <label for="shipping_address">Select address</label>
                                     <select class="form-control" id="shipping_address" name="shipping">
                                       @foreach($addresses as $item)
                                        <option>{{ $item->id  }}|{{ $item->first_name  }}|{{ $item->last_name  }}|{{ $item->email  }}|{{ $item->phone  }}|{{ $item->city  }}|{{ $item->zip_code  }}|{{ $item->address  }}|{{ $item->state  }}|{{ $item->country  }}</option> 
                                       @endforeach            
                                      </select>
                                  </div>
                              <p>
							    <a href="{{ route('addressUser.create') }}"><button type="button" class="btn btn-secondary">Create New Address</button></a>
							  </p>  
                              @endauth                                                                                                              
                                </div>
                                <script type="text/javascript">
                                  $(document).ready(function(){
                                	    
                                	    $(document).on('click', '.addr_same' , function() {
                                	        if (this.value == 1){ 
                                	            $(".subQuestion").hide();           
                                	        } else {
                                	            $(".subQuestion").show();           
                                	        }       
                                	    })
                                	    
                                	});
                                 </script> 
                           	@endif
                           	@else
                           	  <input name="virtual" class="virtual" type="hidden" value="1"/>
                           	@endif                            	      
						</div>
					</div>
					<hr>
					<hr>
					  <strong>Shipping Method</strong>
					   <div class="wpcmsdev-columns">
						<div class="column column-width-two-thirds">
							<p>
							  Shipping Free
							</p>
						</div>
						<div class="column column-width-one-third">
							<p>
							  $0
							</p>
							<input name="shipping_amount" class="shipping" type="hidden" value="0"/> 
						</div>
					</div>
					<hr>
					<hr>
					  <strong>Payment Method</strong>
					  <div class="wpcmsdev-columns">
						<div class="column column-width-two-thirds">
							<p>
							  Some Payment Gateway
							</p>
						</div>
						<div class="column column-width-one-third">
							<p>
							  $0
							</p>
							<input name="payment_fee" class="payment" type="hidden" value="0"/> 
						</div>
					</div>
					<hr>
					  <strong>Order Comment</strong>
					  <div class="wpcmsdev-columns">
						<div class="column column-width-two-thirds">
						   <p>
							 <textarea rows="2" cols="90" name="order_comment"></textarea> 
						   </p>
						</div>
					</div>
					<hr>
					   <table id="place_order" class="table table-hover table-condensed">
						 <tfoot>
							<tr>
								<td><button type="submit"
											class="wpcmsdev-button color-blue">Place order</button></td>
								<td colspan="4" class="hidden-xs"></td>
								<input name="total_amount" type="hidden" value="{{ $totalInCart['price'] }}"/>
								<td class="hidden-xs text-right"><strong>Total to pay: ${{
										$totalInCart['price'] }}</strong></td>
							</tr>
						 </tfoot>
						</table>
						</form>
						@else
						<div class="alert alert-info" role="alert">
							You have no items in your shopping cart.<br> Click <a href="/">here</a>
							to continue shopping.
						</div>
						@endif
					</div>
				</div>
			</main>
			<!-- #main -->
		</div>
		<!-- #primary -->
	</div>
	<!-- #content -->
</div>
<!-- .container -->

@endsection
