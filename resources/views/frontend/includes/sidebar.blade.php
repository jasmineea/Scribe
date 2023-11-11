
@auth
	<button type="button" id="sidebarCollapse" style="margin-left: 29%;border: 1px solid rgba(0,0,0,0.1);padding: 5px 10px;">
                    <i class="fa fa-bars"></i>
				</button>
@endif
<div id="sidebar">
	<!-- <div class="sidebar-toggle">
		<a href="javascript:void(0)"><img src="img/menu.png"></a>
	</div> -->
	<!-- <div class="sidebar-logo">
		<a href="{{ route("frontend.index")}}">
			<img src="{{ asset('img/logo.svg')}}">
		</a>
	</div> -->
	
	<div class="sidebar-menu">
		<label>Overview</label>
		<ul class="sidebar-parent-menu">
			<li><span class="theme-icon ico-rocket"></span><a href="javascript:void(0)" data-id="1">Build Your Campaign <i class="fa fa-angle-up pull-right"></i></a>
				<ul class="sidebar-child-menu {{in_array(request()->route()->getName(),['frontend.cards.step1','frontend.cards.step2','frontend.cards.step3','frontend.cards.step4','frontend.cards.step5','frontend.index','frontend.cards.step3a','frontend.cards.step2a','frontend.cards.step4a','frontend.cards.step4b'])? "show" :"" }}" data-content-id="1">
					{{-- @if(request()->session()->has('step-1')) --}}
					<li id="step-1" class="{{'frontend.cards.step1'==request()->route()->getName()? "active" :"" }}"><a href="{{ route("frontend.cards.step1")}}">Step 01 <span>Create a Campaign or Choose Existing.</span></a></li>
					{{-- @endif --}}
					
					@if(@request()->session()->has('final_array')&&@request()->session()->get('final_array')['campaign_type']=='single')
					<li id="step-2" class="{{'frontend.cards.step2a'==request()->route()->getName()? "active" :"" }}"><a href="{{ route("frontend.cards.step2a")}}">Step 02 <span>Assign Contacts to your Campaign</span></a></li>
					@else
					<li id="step-2" class="{{'frontend.cards.step2'==request()->route()->getName()? "active" :"" }}"><a href="{{ route("frontend.cards.step2")}}">Step 02 <span>Assign Contacts to your Campaign</span></a></li>
					@endif

					{{-- @if(request()->session()->has('step-3')) --}}
					<li id="step-3" class="{{'frontend.cards.step3'==request()->route()->getName()? "active" :"" }}"><a href="{{ route("frontend.cards.step3")}}">Step 03 <span>Compose your Message</span></a></li>
					{{-- @endif --}}
					{{-- @if(request()->session()->has('step-3a')) --}}
					<li id="step-3a" class="{{'frontend.cards.step3a'==request()->route()->getName()||'frontend.cards.step4a'==request()->route()->getName()? "active" :"" }}"><a href="{{ route("frontend.cards.step3a")}}">Step 04 <span>Map your contact list fields</span></a></li>
					{{-- @endif --}}
					{{-- @if(request()->session()->has('step-4')) --}}
					<li id="step-4b" class="{{'frontend.cards.step4b'==request()->route()->getName()? "active" :"" }}"><a href="{{ route("frontend.cards.step4b")}}">Step 05 <span>Approve your design and Submit</span></a></li>
					{{-- @endif --}}
					<!-- {{-- @if(request()->session()->has('step-5')) --}}
					<li  id="step-5" class="{{'frontend.cards.step5'==request()->route()->getName()? "active" :"" }}"><a href="{{ route("frontend.cards.step5")}}">Step 06 <span>Submit your compaign</span></a></li>
					{{-- @endif --}} -->

				</ul>
			</li>
		</ul>
		<hr>
		<label>Resources</label>
		<ul class="sidebar-parent-menu">
			<li><span class="theme-icon ico-api"></span><a href="javascript:void(0)" data-id="2">API &amp; Integrations  <span class="badge bg-danger badge_bg_color">Coming Soon</span><i class="fa fa-angle-down pull-right"></i></a>
				<ul class="sidebar-child-menu  {{in_array(request()->route()->getName(),['frontend.cards.zapierImport','frontend.cards.makeImport'])? "show" :"" }}" " data-content-id="2">
					<li><a  href="{{ route("frontend.cards.zapierImport")}}">Import Recipients using Zapier<span>Import Recipients</span></a></li>
					<li><a  href="{{ route("frontend.cards.makeImport")}}">Import Recipients using Make.com<span>Import Recipients</span></a></li>
					<li><a  href="#">Steps to be folllowed for Integrations<span>step by step guidance</span></a></li>
				</ul>

			</li>
			<li><span class="theme-icon ico-marketing"></span><a href="javascript:void(0)" data-id="3">Marketing Tools <span class="badge bg-danger badge_bg_color">Coming Soon</span> <i class="fa fa-angle-down pull-right"></i></a>
				<ul class="sidebar-child-menu" data-content-id="3">
					<li><a href="#">Scribe AI Copy Writer </a></li>
					<li><a href="#">Scribe AI List Builder</a></li>
					<li><a href="#">Scribe localize Tracking Number And QR Code  </a></li>
					<li><a href="#">Scribe University</a></li>
				</ul>

			</li>
			<li><span class="theme-icon ico-glove"></span><a href="javascript:void(0)" data-id="4">White Glove Agency <span class="badge bg-danger badge_bg_color">Coming Soon</span> <i class="fa fa-angle-down pull-right"></i></a>
				<ul class="sidebar-child-menu" data-content-id="4">
					<li><a href="#">Data List Building And Forming</a></li>
					<li><a href="#">Custom Expert Copy Writing</a></li>
					<li><a href="#">Custom Call Tracking And A/B testing</a></li>
					<li><a href="#">Custom mail keys and card designs</a></li>
				</ul>

			</li>

		</ul>
		<hr>
		<label>Set up</label>
		<ul class="sidebar-parent-menu">
			<li><span class="theme-icon ico-help"></span><a href="javascript:void(0)" data-id="5">Need Help?</a></li>
			<li><span class="theme-icon ico-demo"></span><a href="javascript:void(0)" data-id="6">Book a Demo</a></li>
		</ul>
		<hr>
		@auth
		<ul class="sidebar-parent-menu">
			<li><span class="theme-icon ico-account"></span><a href="javascript:void(0)" data-id="7">My Account</a> <i class="fa fa-angle-down pull-right"></i></li>
				<ul class="sidebar-child-menu {{in_array(request()->route()->getName(),['frontend.users.profile','frontend.cards.returnaddress','frontend.cards.wallet','frontend.cards.orders','frontend.cards.listing','frontend.cards.contacts','frontend.users.profileEdit','frontend.cards.orderDetail'])? "show" :"" }}" data-content-id="7">
					<li><a href="{{ route('frontend.users.profile', encode_id(auth()->user()->id)) }}">My Profile</a></li>
					<li><a href="{{ route("frontend.cards.wallet") }}">My Wallet</a></li>
					<li><a href="{{ route("frontend.cards.orders") }}">My Campaigns</a></li>
					<li><a href="{{ route("frontend.cards.listing") }}">My Recipient List</a></li>
					<li><a href="{{ route("frontend.cards.returnaddress") }}">My Return Addresses</a></li>
					<li><a href="{{ route('frontend.users.profileEdit', encode_id(auth()->user()->id)) }}">Settings</a></li>
					<li><a href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
				</ul>

			</li>
		</ul>
		@endauth
	</div>
</div>