@php
if(user_has_role(@auth()->user()->id)){
$url=route("backend.dashboard");
header("Location: ".$url);
exit;
}
@endphp
<header id="header">
	<div class="container-fluid header">
		<div class="row">

			<div class="col-6 d-f a-i-c">

				<div class="logo">
					<a href="{{ route("frontend.index")}}">
						<img src="{{asset('img/logo.svg')}}">
					</a>
				</div>
				@auth
				<button type="button" id="sidebarCollapse" style="margin-left: 29%;border: 1px solid rgba(0,0,0,0.1);padding: 5px 10px;">
                    <i class="fa fa-bars"></i>
				</button>
				@endif
			</div>

			<div class="col-6 d-f a-i-c j-c-e">
				<div class="main-menu">
					<ul>
						<li><a href="#">Pricing</a></li>
						<li><a href="#">Book a Demo</a></li>
                        @guest
						<li><a class="theme-btn" href="{{ route('login') }}">Login</a></li>
                        @endguest

                        @auth
                        @can('view_backend')
                        {{-- <li><a class="theme-btn" href='{{ route("backend.dashboard") }}'>
                            {{__('Dashboard')}}
                        </a></li> --}}
                        @endif
                        {{-- <li><a class="theme-btn" href="{{ route('frontend.users.profile', encode_id(auth()->user()->id)) }}">Profile</a></li>
                        <li><a class="theme-btn" href="{{ route('frontend.users.profileEdit', encode_id(auth()->user()->id)) }}">{{__('Settings')}}</a></li> --}}
                        <li><a class="theme-btn"  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                        @endauth
					</ul>
				</div>
			</div>
		</div>
	</div>
</header>