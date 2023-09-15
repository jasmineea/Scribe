<?php
$notifications = optional(auth()->user())->unreadNotifications;
$notifications_count = optional($notifications)->count();
$notifications_latest = optional($notifications)->take(5);
?>

<header class="header header-sticky mb-4">
    <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <i class="fa-solid fa-bars"></i>
        </button>
        <a class="header-brand d-md-none" href="#">
            <img class="sidebar-brand-full" src="{{asset("img/logo.svg")}}" height="46" alt="{{ app_name() }}">
        </a>
        <ul class="header-nav d-none d-md-flex">
            <li class="nav-item"><a class="nav-link" href="{{ route('frontend.index') }}" target="_blank">{{app_name()}}&nbsp;<i class="fa-solid fa-arrow-up-right-from-square"></i></a></li>
            <li class="nav-item"><div class="dropdown" style="margin-left: 50px;">
  <div id="myDropdown" class="dropdown-content">
    <input type="text" placeholder="Search Here..." id="myInput" onkeyup="filterFunction()">
  </div>
</div></li>
        </ul>
        <ul class="header-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa-regular fa-bell"></i>
                    &nbsp; @if($notifications_count)<span class="badge badge-pill bg-danger">{{$notifications_count}}</span>@endif
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <strong>@lang("You have :count notifications", ['count'=>$notifications_count])</strong>
                    </div>

                    @if($notifications_latest)
                    @foreach($notifications_latest as $notification)
                    @php
                    $notification_text = isset($notification->data['title'])? $notification->data['title'] : $notification->data['module'];
                    @endphp
                    <a class="dropdown-item" href="{{route("backend.notifications.show", $notification)}}">
                        <i class="{{isset($notification->data['icon'])? $notification->data['icon'] : 'fa-solid fa-bullhorn'}} "></i>&nbsp;{{$notification_text}}
                    </a>
                    @endforeach
                    @endif
                </div>
            </li>
        </ul>

        <ul class="header-nav ms-3">
            <li class="nav-item dropdown">
                <a class="nav-link" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="fa-solid fa-language"></i>&nbsp; {{strtoupper(App::getLocale())}}
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">{{ __('Change language') }}</div>
                    </div>
                    @foreach(config('app.available_locales') as $locale => $title)
                    <a class="dropdown-item" href="{{route("language.switch", $locale)}}">
                        {{ $title }}
                    </a>
                    @endforeach
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md">
                        <img class="avatar-img" src="{{ asset(auth()->user()->avatar) }}" alt="{{ asset(auth()->user()->name) }}">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">{{ __('Account') }}</div>
                    </div>

                    <a class="dropdown-item" href="{{route('backend.users.profile', Auth::user()->id)}}">
                        <i class="fa-regular fa-user me-2"></i>&nbsp;{{ Auth::user()->name }}
                    </a>
                    <a class="dropdown-item" href="{{route('backend.users.profile', Auth::user()->id)}}">
                        <i class="fa-regular fa-user me-2"></i>&nbsp;{{ Auth::user()->email }}
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route("backend.notifications.index") }}">
                        <i class="fa-regular fa-bell me-2"></i>&nbsp;
                        @lang('Notifications') <span class="badge bg-danger ml-auto">{{$notifications_count}}</span>
                    </a>

                    <div class="dropdown-header bg-light py-2"><strong>@lang('Settings')</strong></div>

                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket me-2"></i>&nbsp;
                        @lang('Logout')
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>

                </div>
            </li>
        </ul>
    </div>

    <div class="header-divider"></div>

    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
                @yield('breadcrumbs')
            </ol>
        </nav>
        <div class="d-flex flex-row float-end">
            <div class="">{{ date_today() }}&nbsp;</div>
            <div id="liveClock" class="clock" onload="showTime()"></div>
        </div>
    </div>
</header>
<style>
.dropbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropbtn:hover, .dropbtn:focus {
  background-color: #3e8e41;
}

#myInput {
    box-sizing: border-box;
    background-image: url(searchicon.png);
    background-position: 14px 12px;
    background-repeat: no-repeat;
    font-size: 16px;
    padding: 10px 20px 12px 45px;
    border: none;
    border-bottom: 1px solid #ddd;
}

#myInput:focus {outline: 3px solid #ddd;}


.dropdown-content {
    display: block;
    position: absolute;
    background-color: #f6f6f6;
    min-width: 230px;
    overflow: auto;
    border: 1px solid #ddd;
    z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}
</style>
<script>
     function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
    }

    function filterFunction() {
        var str = 'query='+$("#myInput").val();
        $.ajax({
            type: "GET",
            url: '{{route("backend.search")}}',
            data: str,
            success: function (data) {
                $(".dropdown-content a").remove();
                $(".dropdown-content").append(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }

        });

    }
</script>
@push('after-scripts')
<script type="module">
    // document.addEventListener('DOMContentLoaded', function() {
    //     $(function() {
    //         // Show the time
    //         showTime();
    //     })
    // }, false);

    $(function() {
        // Show the time
        showTime();
    })


    function showTime() {
        var date = new Date();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seconds = date.getSeconds();

        var session = hours >= 12 ? 'pm' : 'am';

        hours = hours % 12;
        hours = hours ? hours : 12;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        var time = hours + ":" + minutes + ":" + seconds + " " + session;
        document.getElementById("liveClock").innerText = time;
        document.getElementById("liveClock").textContent = time;

        setTimeout(showTime, 1000);
    }
</script>
@endpush