 <nav id="site-navigation" class="main-navigation">

	<button class="menu-toggle" onclick="showMenu();">Menu</button>
	<a class="skip-link screen-reader-text" href="">Skip to content</a>
	<div class="menu-menu-1-container">
		<ul id="menu-menu-1" class="menu">
			<li><a href="{{ url('/') }}">Home</a></li>
			<li><a href="{{ route('addBuisness') }}">Add a Buisness</a></li>
			<li><a href="{{ route('googleMapStore.index') }}"><img src="../img/map-8.png"
					height="40" width="40" /></a></li>
		</ul>
	</div>
</nav>