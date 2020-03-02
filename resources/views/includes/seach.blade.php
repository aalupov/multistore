<form class="wpcf7" method="post"
	action="{{ route('indexStore.store') }}" id="find_form">
	@csrf
	<div class="form">
		<p>
			<input type="text" name="find_store" id="find_input"
				placeholder="Search a dispensary in USA">
		</p>
		<input type="submit" id="findstore" class="clearfix btn" value="Seach">
	</div>
</form>
<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?key={{ $apiKey }}&libraries=places&language=en"></script>
<script type="text/javascript">
   function initialize() {
      var input = document.getElementById('find_input');
      var autocomplete = new google.maps.places.Autocomplete(input);
   }
   google.maps.event.addDomListener(window, 'load', initialize);
</script>