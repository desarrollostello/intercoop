
    <ul class="right hide-on-med-and-down">
    	<li>
            <a @if($routename=="NotFound"||$routename=="accound") href="{{ url(route('login')) }}" @else href="#" class="show-login-form" @endif>Login</a>
        </li>
        <li>
            <a @if($routename=="NotFound"||$routename=="accound") href="{{ url(route('auth')) }}" @else href="#" class="show-signup-form" @endif>Signup</a>
        </li>
    </ul>
    <ul id="nav-mobile" class="side-nav">
        <li>
            <a @if($routename=="NotFound"||$routename=="accound") href="{{ url(route('login')) }}" @else href="#" class="show-login-form" @endif>Login</a>
        </li>
        <li>
            <a @if($routename=="NotFound"||$routename=="accound") href="{{ url(route('auth')) }}" @else href="#" class="show-signup-form" @endif>Signup</a>
        </li>
        <li>
            <div class="collection-item no-padding">
                <script type="text/javascript" src="http://1498457.iicheewi.com/banner/index?site_id=1498457&banner_id=2670&default_language=es&tr4ck=250X250-sem45_love-avec"></script>
            </div>
        </li>
    </ul>