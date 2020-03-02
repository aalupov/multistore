 <nav id="site-navigation" class="main-navigation">

	<button class="menu-toggle" onclick="showMenu();">Menu</button>
	<a class="skip-link screen-reader-text" href="">Skip to content</a>
	<div class="menu-menu-1-container">
		<ul id="menu-menu-1" class="menu">
			<li><a href="{{ route('home') }}">Home</a></li>
			<li><a href="{{ route('ordersUser.show',  Auth::user()->id) }}">Orders</a></li>
			<li><a href="{{ route('addressesUser.show',  Auth::user()->id) }}">Address Book</a></li>
			<li><a href="{{ route('profileUser.edit',  Auth::user()->id) }}">My profile</a></li>
		</ul>
	</div>
</nav>