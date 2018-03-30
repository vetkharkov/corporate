@if($menu)
	<div class="menu classic">
		<ul id="nav" class="menu">
			{{--$menu->roots() формирует только родительское меню--}}
			@include(config('settings.theme').'.customMenuItems',['items'=>$menu->roots()])
		</ul>
	</div>
@endif
