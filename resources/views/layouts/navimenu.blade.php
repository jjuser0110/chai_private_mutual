<div id="navi-menu">
	<a id="home-icon" class="menu-item" onclick="loadPage('{{ route('index') }}')">
		<i class="ri-xl ri-home-3-line"></i>
		<label>Home</label>
	</a>
	<a id="join-icon" class="menu-item" onclick="loadPage('{{ route('join') }}')">
		<i class="ri-xl ri-menu-line"></i>
		<label>Join</label>
	</a>
	<a id="shop-icon" class="menu-item" onclick="loadPage('{{ route('shop') }}')">
		<i class="ri-xl ri-shopping-bag-line"></i>
		<label>Shop</label>
	</a>
	<a id="account-icon" class="menu-item" onclick="loadPage('{{ route('account') }}')">
		<i class="ri-xl ri-account-circle-line"></i>
		<label>My</label>
	</a>
</div>
