<nav id="site-navigation" class="main-navigation">

	<button class="menu-toggle" onclick="showMenu();">Menu</button>
	<a class="skip-link screen-reader-text" href="">Skip to content</a>
	<div class="menu-menu-1-container">
		<ul id="menu-menu-1" class="menu">
			<li><a href="{{ route('storePage.show', $storeInfo->id) }}">{{$storeInfo->store_title}}</a></li>
			@if(isset($namesOfCategories['parents']))
			 @foreach($namesOfCategories['parents'] as $parent_id => $parents)

			<li>{{$parents['category_name']}}
				<ul class="sub-menu">
				 @if(isset($namesOfCategories['childrens']))
					@foreach($namesOfCategories['childrens'][$parent_id] as $childrens)
					<li><a href="{{ route('categoryPage.show', $childrens['category_id']) }}">{{$childrens['category_name']}}</a></li>
					@endforeach
				 @endif		
				</ul></li> @endforeach
		    @endif		
		</ul>
	</div>
</nav>