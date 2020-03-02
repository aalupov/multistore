	@include('includes.error')
	@include('includes.success')
					<div class="wpcmsdev-columns">
						<div class="column column-width-one-half">
							<h4>Contact Us</h4>						
							
							<form class="wpcf7" method="post" action="{{ route('storeMailSend') }}" id="contactform">
							@csrf
								<div class="form">
								    <input type="hidden" name="receiver_email" value="{{$storeInfo->store_email}}">
								    <input type="hidden" name="receiver_name" value="{{$storeInfo->store_title}}">
									<p><input type="text" name="name" value="{{ old('name') }}" placeholder="Name *"></p>
									<p><input type="email" name="email" value="{{ old('email') }}" placeholder="E-mail Address *"></p>
									<p><input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone number"></p>
									<p><textarea name="message" rows="3" placeholder="Message *">{{ old('message') }}</textarea></p>
									<input type="submit" id="submit" name="store-contact-form" class="clearfix btn" value="Send">
								</div>
							</form>							
						</div>
						<div class="column column-width-one-half">
							<h4>Find Us: {{$storeInfo->store_phone}}</h4>
							<p>
								If you want to hire me or have any feedback or questions about our service in general, please send us a message by completing our enquiry form. It's best to call though, someone we will always be there for you.
							</p>
							<p>
								<h5>We are timeable at:</h5>
							</p>
							<p>
							 @if(isset($storeInfo->time_shedule))
							    @foreach($storeInfo->time_shedule as $items)
							       @if ($items->opened_at != NULL)
								     <b>{{$items->day_of_week}}</b>: {{$items->opened_at}} to {{$items->closed_at}}<br>
								   @else
								     <b>{{$items->day_of_week}}</b>: Closed<br>
								   @endif
								 @endforeach	
							  @endif	 
							</p>
						</div>
					</div>
				</div>