        
    <!-- Nav normal -->
    <ul class="right">
        <!--<li class="hide-on-med-and-down">
            <a href="#" class="dropdown-button" data-activates='dropdown1'>
                <img src="<?php echo e(asset('img/largeImage_18907603.jpeg')); ?>" alt="avatar" style="position:relative;top:.8rem;" width="35" class="responsive-img circle"> <?php echo e(Auth::user()->user_name); ?> <i class="icon-caret-down right"></i>
            </a>
        </li>
        <ul id='dropdown1' class='dropdown-content' style="width: 200px !important">
            <li>
                <a href="<?php echo e(url('/home')); ?>">
                    Inicio
                </a>
            </li>
            <li>
                <a href="#!">
                    Profile
                </a>
            </li>
            <li>
                <a href="#!">two</a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="<?php echo e(url('/auth/logout')); ?>">Logout</a>
            </li>
        </ul>-->
        <li class="list-item-notification" style="height:64px;">
            <a href="#" class="element-of-message show-messages" data-beloworigin="true" data-activates='content-notifies-messages'>
                <i class="material-icons element-of-message">mail</i>
                <span class="icon-message-count-notifications animated bounceIn infinite">
                    <?php echo e(isset($count_messages) && !empty($count_messages) ? ($count_messages>10) ? '+10' : $count_messages : null); ?>

                </span>
            </a>
            <div class="content-notifies content-notifies-messages" id="content-notifies-messages">
                <div class="col s12 no-padding mpadding white" style="line-height: normal">
                    <b class="grey-text text-darken-2">Messages</b>
                    <a href="<?php echo e(route('messages')); ?>" class="blue-text text-lighten-1 right" style="line-height: normal">View all</a>
                </div>
                <ul class="list-notifies messages"></ul>
            </div>
        </li>
        <li class="list-item-notification" style="height:64px;">
            <a href="#" class="element-of-notification show-notifies" data-beloworigin="true" data-activates='content-notifies-notifies'>
                <i class="material-icons element-of-notification">notifications</i>
                <span class="icon-count-notifies animated bounceIn infinite">
                    <?php echo e((isset($count_notifies) && !empty($count_notifies)) ? ($count_notifies>10) ? '+10' : $count_notifies : null); ?>

                </span>
            </a>

            <div class="content-notifies content-notifies-notifies" id="content-notifies-notifies">
                <div class="col s12 no-padding mpadding white" style="line-height: normal">
                    <b class="grey-text text-darken-2">Notifies</b>
                    <a href="#" class="blue-text text-lighten-1 right" style="line-height: normal">View all</a>
                </div>
                <ul class="list-notifies notifies"></ul>
            </div>
        </li>
    </ul>
    <!-- End nav normal -->
    
    <!-- Nav mobile -->
    <div id="nav-mobile" class="side-nav collection" style="background: white;top: 0px;">
        <!-- Aside menu left -->
        <?php echo $__env->make('includes.aside-menu-left', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- End aside menu left -->
    </div>
    <!-- End nav mobile -->