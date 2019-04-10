
    <a class="disabled collection-item hide-on-large-only">Favorites</a>

    <a class="collection-item {{ $routename == "profile" ? "active" : null }}" href="{{ url('/profile') }}" style="line-height: normal;height: auto;">
        <div style="display:inline-block;vertical-align: middle">
            @if(!File::exists(Auth::user()->profile->avatar->small))
                <img src="{{ asset('img/default_avatar.png') }}" alt="image-not-found" width="35" class="responsive-img circle profile-avatar-small">
            @else
                <img src="{{ asset(Auth::user()->profile->avatar->small) }}" alt="avatar" width="35" class="responsive-img circle profile-avatar-small">
            @endif
        </div>
        
        <div class="user-display-name" style="display:inline-block;vertical-align: middle">
            <div style="vertical-align: middle;max-width: 115px;display: inline-block;">
                <span class="title truncate">{{ Auth::user()->user_name }}</span>
                <span class="grey-text text-lighten-1 truncate">
                    <small class="grey-text text-lighten-1 truncate">{{ Auth::user()->first_name ." ". Auth::user()->last_name }}</small>
                </span>
            </div>
            <span class="spinner-icon-hidden hidden-block" style="vertical-align: middle;width: 10px;"><i class="icon-spinner icon-spin"></i></span>
        </div>
    </a>

    <a href="{{ route('new-post') }}" class="collection-item menu-item-new-post">
        <i class="icon-edit-sign menu-icon"></i> <span>{{ trans('left_menu.menu_publish_state') }}</span>
    </a>

    @if(Auth::user()->role=='s_admin'||Auth::user()->role=='admin')
        <a href="{{ route('home-admin') }}" class="collection-item">
            <i class="icon-gears menu-icon"></i> <span>{{ trans('left_menu.menu_admin') }}</span>
        </a>
    @endif
    <a class="collection-item {{ $routename == "home" ? "active" : null }}" href="{{ url('/home') }}">
        <i class="icon-home menu-icon"></i> <span>{{ trans('left_menu.menu_home') }}</span>
    </a>

    <!--<a class="collection-item" href="{{ url(route('messages')) }}">
        <i class="icon-envelope menu-icon"></i> <span>Messages</span>
    </a>-->

    {{--<a class="collection-item" href="#">
        <i class="icon-picture menu-icon"></i> <span>Photos</span>
    </a>

    <a class="collection-item" href="#">
        <i class="icon-eye-open menu-icon"></i> <span>Views</span>
    </a>

    <a class="collection-item" href="#">
    	<i class="icon-heart menu-icon"></i> <span>Matches</span>
    </a>--}}

    <a class="collection-item {{ $routename == "contacts" ? "active" : null }}" href="{{ url(route('contacts')) }}">
        <i class="icon-user menu-icon"></i> <span>{{ trans('left_menu.menu_contacts') }}</span>
    </a>

    <a class="collection-item {{ $routename == "visitors" ? "active" : null }}" href="{{ url(route('visitors')) }}">
        <i class="icon-group menu-icon"></i> <span>{{ trans('left_menu.menu_visitors') }}</span>
    </a>

    <!--<a href="{{ url('/') }}" class="collection-item {{ $routename == "favorites" ? "active" : null }}">
        <i class="icon-star menu-icon"></i> <span>{{ trans('left_menu.menu_favorites') }}</span>
    </a>-->

    <a href="{{ route('likes') }}" class="collection-item {{ $routename == "likes" ? "active" : null }}">
        <i class="icon-heart menu-icon"></i> <span>Likes</span>
    </a>

    <a class="collection-item {{ $routename == "search" ? "active" : null }}" href="{{ url(route('search')) }}">
        <i class="icon-search menu-icon"></i> <span>{{ trans('left_menu.menu_search') }}</span>
    </a>
    <div class="divider hide-on-large-only"></div>

    <a class="collection-item" href="{{ url('/auth/logout') }}">
        <i class="icon-signout menu-icon"></i> <span>{{ trans('left_menu.menu_logout') }}</span>
    </a>
    {{--<div class="collection-item no-padding">
        <script type="text/javascript" src="http://1498457.iicheewi.com/banner/index?site_id=1498457&banner_id=2670&default_language=es&tr4ck=250X250-sem45_love-avec"></script>
    </div>--}}
