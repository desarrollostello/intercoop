
    <a class="disabled collection-item hide-on-large-only">Favorites</a>

    <a class="collection-item <?php echo e($routename == "profile" ? "active" : null); ?>" href="<?php echo e(url('/profile')); ?>" style="line-height: normal;height: auto;">
        <div style="display:inline-block;vertical-align: middle">
            <?php if(!File::exists(Auth::user()->profile->avatar->small)): ?>
                <img src="<?php echo e(asset('img/default_avatar.png')); ?>" alt="image-not-found" width="35" class="responsive-img circle profile-avatar-small">
            <?php else: ?>
                <img src="<?php echo e(asset(Auth::user()->profile->avatar->small)); ?>" alt="avatar" width="35" class="responsive-img circle profile-avatar-small">
            <?php endif; ?>
        </div>
        
        <div class="user-display-name" style="display:inline-block;vertical-align: middle">
            <div style="vertical-align: middle;max-width: 115px;display: inline-block;">
                <span class="title truncate"><?php echo e(Auth::user()->user_name); ?></span>
                <span class="grey-text text-lighten-1 truncate">
                    <small class="grey-text text-lighten-1 truncate"><?php echo e(Auth::user()->first_name ." ". Auth::user()->last_name); ?></small>
                </span>
            </div>
            <span class="spinner-icon-hidden hidden-block" style="vertical-align: middle;width: 10px;"><i class="icon-spinner icon-spin"></i></span>
        </div>
    </a>

    <a href="<?php echo e(route('new-post')); ?>" class="collection-item menu-item-new-post">
        <i class="icon-edit-sign menu-icon"></i> <span><?php echo e(trans('left_menu.menu_publish_state')); ?></span>
    </a>

    <?php if(Auth::user()->role=='s_admin'||Auth::user()->role=='admin'): ?>
        <a href="<?php echo e(route('home-admin')); ?>" class="collection-item">
            <i class="icon-gears menu-icon"></i> <span><?php echo e(trans('left_menu.menu_admin')); ?></span>
        </a>
    <?php endif; ?>
    <a class="collection-item <?php echo e($routename == "home" ? "active" : null); ?>" href="<?php echo e(url('/home')); ?>">
        <i class="icon-home menu-icon"></i> <span><?php echo e(trans('left_menu.menu_home')); ?></span>
    </a>

    <!--<a class="collection-item" href="<?php echo e(url(route('messages'))); ?>">
        <i class="icon-envelope menu-icon"></i> <span>Messages</span>
    </a>-->

    <?php /*<a class="collection-item" href="#">
        <i class="icon-picture menu-icon"></i> <span>Photos</span>
    </a>

    <a class="collection-item" href="#">
        <i class="icon-eye-open menu-icon"></i> <span>Views</span>
    </a>

    <a class="collection-item" href="#">
    	<i class="icon-heart menu-icon"></i> <span>Matches</span>
    </a>*/ ?>

    <a class="collection-item <?php echo e($routename == "contacts" ? "active" : null); ?>" href="<?php echo e(url(route('contacts'))); ?>">
        <i class="icon-user menu-icon"></i> <span><?php echo e(trans('left_menu.menu_contacts')); ?></span>
    </a>

    <a class="collection-item <?php echo e($routename == "visitors" ? "active" : null); ?>" href="<?php echo e(url(route('visitors'))); ?>">
        <i class="icon-group menu-icon"></i> <span><?php echo e(trans('left_menu.menu_visitors')); ?></span>
    </a>

    <!--<a href="<?php echo e(url('/')); ?>" class="collection-item <?php echo e($routename == "favorites" ? "active" : null); ?>">
        <i class="icon-star menu-icon"></i> <span><?php echo e(trans('left_menu.menu_favorites')); ?></span>
    </a>-->

    <a href="<?php echo e(route('likes')); ?>" class="collection-item <?php echo e($routename == "likes" ? "active" : null); ?>">
        <i class="icon-heart menu-icon"></i> <span>Likes</span>
    </a>

    <a class="collection-item <?php echo e($routename == "search" ? "active" : null); ?>" href="<?php echo e(url(route('search'))); ?>">
        <i class="icon-search menu-icon"></i> <span><?php echo e(trans('left_menu.menu_search')); ?></span>
    </a>
    <div class="divider hide-on-large-only"></div>

    <a class="collection-item" href="<?php echo e(url('/auth/logout')); ?>">
        <i class="icon-signout menu-icon"></i> <span><?php echo e(trans('left_menu.menu_logout')); ?></span>
    </a>
    <?php /*<div class="collection-item no-padding">
        <script type="text/javascript" src="http://1498457.iicheewi.com/banner/index?site_id=1498457&banner_id=2670&default_language=es&tr4ck=250X250-sem45_love-avec"></script>
    </div>*/ ?>
