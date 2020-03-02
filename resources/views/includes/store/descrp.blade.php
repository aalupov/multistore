<div class="wpcmsdev-toggle">
	<h3 class="toggle-title">
		<a href="#toggle-what-is-lore-ipsum"><i
			class="fa fa-plus icon-for-inactive"></i><i
			class="fa fa-minus icon-for-active"></i>About
			{{$storeInfo->store_title}}</a>
	</h3>
	<div id="toggle-what-is-lore-ipsum" class="toggle-content">
		<p>{{$storeInfo->store_description}}</p>
		<a class="wpcmsdev-button color-green"
			href="{{ route('storeMailSendPage.show', $storeInfo->id) }}"><span>Contact us</span></a>
	</div>
</div>