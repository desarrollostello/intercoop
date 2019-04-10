<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="theme-color" content="#29b6f6"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <!--<link href="<?php echo e(asset('img/favicon.ico')); ?>" rel="icon" type="image/x-icon" />-->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo e(asset('img/apple-icon-57x57.png')); ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo e(asset('img/apple-icon-60x60.png')); ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo e(asset('img/apple-icon-72x72.png')); ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('img/apple-icon-76x76.png')); ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo e(asset('img/apple-icon-114x114.png')); ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo e(asset('img/apple-icon-120x120.png')); ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo e(asset('img/apple-icon-144x144.png')); ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo e(asset('img/apple-icon-152x152.png')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('img/apple-icon-180x180.png')); ?>">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo e(asset('img/android-icon-192x192.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('img/favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo e(asset('img/favicon-96x96.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('img/favicon-16x16.png')); ?>">
    <link rel="manifest" href="<?php echo e(asset('img/manifest.json')); ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo e(asset('img/ms-icon-144x144.png')); ?>">
    <meta name="theme-color" content="#ffffff">
    <title><?php echo e((isset($tap_title))?$tap_title:env('APP_NAME')); ?></title>

    <?php $__env->startSection('main-styles'); ?>
        <!-- CSS  -->
        <?php echo Html::style('css/materialize.min.css'); ?>

        <?php echo Html::style('css/datepicker.min.css'); ?>

        <?php echo Html::style('css/mbox-0.0.1.min.css'); ?>

        <?php echo Html::style('css/m-d-c-p.min.css'); ?>

        <?php echo Html::style('css/font-awesome.min.css'); ?>

        <?php echo Html::style('css/style.css'); ?>


    <?php echo $__env->yieldSection(); ?>
</head>
<body>
<div id="main-modal" class="modal"></div>
<?php if(!Auth::check()): ?>
    <div class="bg-background"></div>
<?php endif; ?>
<?php if(session()->has('flash_notification.message')): ?>
    
<?php endif; ?>
<div class="navbar-fixed change-nav" style="z-index: 3000;">
    <nav class="light-blue lighten-1" role="navigation">
        <div class="nav-wrapper container">
            <a id="logo-container" href="<?php echo e(url('/?href=title')); ?>" class="brand-logo">
                <img src="<?php echo e(asset('img/logo-2.png')); ?>" width="40" alt=""> <span><?php echo e(APP_NAME); ?></span>
            </a>
            <?php if(Auth::check()): ?>
                <?php echo $__env->make('includes.logged-menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php else: ?>
                <?php echo $__env->make('includes.unlogged-menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endif; ?>
            <a href="#" data-activates="nav-mobile" class="button-collapse">
                <i class="icon-reorder"></i>
            </a>
        </div>
    </nav>
</div>
<?php echo $__env->yieldContent('content'); ?>
<?php if(Auth::check()&&Auth::user()->role=='user'||!Auth::check()): ?>
<div class="center adnow-ad" style="overflow: hidden;overflow-x: scroll;">
    <?php if(!Auth::check()): ?>

    <?php endif; ?>
    <?php if(Auth::check()&&Auth::user()->role=='user'): ?>

    <?php endif; ?>
</div>
<?php endif; ?>
<footer class="page-footer grey">
    <div class="container">
        <div class="row">
            <div class="col l5 s12">
                <h5 class="white-text"><?php echo e(APP_NAME); ?></h5>
                <p class="grey-text text-lighten-4">
                We are a team of college students working on this project like it's 
                our full time job. Any amount would help support and continue development 
                on this project and is greatly appreciated.</p>            
            </div>
            <div class="col l3 s12 footer-social-icons">
                <h5 class="white-text">Social</h5>
                <ul>
                    <li>
                        <a class="white-text block" href="https://www.facebook.com/pheaksite/" target="_blank">
                            <span>Facebook</span> <i class="icon-facebook-sign mdc-text-indigo-700"></i>
                        </a>
                    </li>
                    <li>
                        <a class="white-text block" href="#!">
                            <span>Twitter</span> <i class="icon-twitter-sign mdc-text-light-blue-600"></i>
                        </a>
                    </li>
                    <li>
                        <a class="white-text block" href="#!">
                            <span>Google</span> <i class="icon-google-plus-sign mdc-text-red-500"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col l4 s12">
                <h5 class="white-text">Report a problem</h5>
                <!--<?php echo e(Form::open(['url'=>'/'])); ?>

                    <div class="row">
                        <div class="input-field field-footer col s12 m6 l12">
                            <input id="email" type="text" class="validate" value="<?php echo e((Auth::check()) ? Auth::user()->email : ""); ?>">
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field field-footer col s12 m6 l12">
                            <input id="username" type="text" class="validate" value="<?php echo e((Auth::check()) ? Auth::user()->user_name : ""); ?>">
                            <label for="username">Username</label>
                        </div>
                        <div class="input-field field-footer col s12">
                            <textarea id="desc-problem" class="materialize-textarea"></textarea>
                            <label for="desc-problem">Describe your problem</label>
                        </div>
                        <div class="input-field">
                            <?php echo e(Form::select('country', array('US' => 'United States', 'UK' => 'United Kingdom'))); ?>

                        </div>
                    </div>
                <?php echo e(Form::close()); ?>-->
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container white-text">
            Made by <a class="blue-text text-lighten-2" href="http://www.twitter.com/ma3xcodes" target="_blank">ma3xcodes</a>
            <!--<a href="#" class="white-text text-lighten-2 right change-lang">
                <i class="icon-globe"></i> Language
            </a>-->
        </div>
    </div>
</footer>

<span id="application-token" data-token="<?php echo e(csrf_token()); ?>"></span>
<?php $__env->startSection('main-javascripts'); ?>
    <!--  Scripts-->
    <script src="<?php echo e(asset("js/jquery.min.js")); ?>"></script>
    <script src="<?php echo e(asset("js/datepicker.min.js")); ?>"></script>
    <script src="<?php echo e(asset('js/moment.js')); ?>"></script>
    <script src="<?php echo e(asset("js/materialize.js")); ?>"></script>
    <script src="<?php echo e(asset('js/mbox-0.0.1.min.js')); ?>"></script>
    <script src="//js.pusher.com/3.2/pusher.min.js"></script>
    <script src="<?php echo e(asset("js/clamp.min.js")); ?>"></script>
    <script src="<?php echo e(asset("js/init.min.js")); ?>"></script>
    <?php echo Html::script("plugins/infinite-scroll/jquery.infinite-scroll.min.js"); ?>

    <?php if(Auth::check()): ?>
        <script>
            (function(){
                $.getScript('<?php echo e(asset('pusher/pusher-connection.js')); ?>', function(data){
                    channel.bind('event-message', function(data) {
                        console.log($('#list-chat').data('user-name'));
                        console.log(data.from_user_name);
                        if(data.from_user_name === $('#list-chat').data('user-name')) {
                            var tochat = $('<li id="item-chat" class="item-chat left-align left-item" data-created="' + data.str_to_time + '">' +
                                '<div style="display: inline-block;vertical-align: baseline">' +
                                    '<img src="' + data.image_url + '" class="circle img-responsive" width="40" alt="">' +
                                '</div>' +
                                '<div class="item-chat-content mpadding grey lighten-1 margin-l" style="display: inline-block;vertical-align: baseline;border-radius: 5px;border-bottom-left-radius: 0;">' +
                                    '<span class="white-text">' + data.str_text + '</span>' +
                                    '<small class="d-block grey-text text-darken-1 create-at"></small>' +
                                '</div>' +
                            '</li>');
                            $('#list-chat').append(tochat);
                            autoScroll();
                            if($('#chat-sound-control').is(':checked')) {
                                $('#chatAudio')[0].play();
                            }
                        }else {
                            var notifi_element = $('span.icon-message-count-notifications');
                            var title_element = $('title');
                            var notifies_count = parseInt(notifi_element.text());
                            if(isNaN(notifies_count)){
                                notifi_element.text(1)
                            }else {
                                notifi_element.text(notifi_element.text() != "" ? parseInt(notifi_element.text()) + 1 : 1);
                            }

                            var $toastContent = $('<a href="<?php echo e(url('messages/')); ?>/' + data.from + '" class="blue lighten-1 padding white-text">' + data.text + '</a>');
                            Materialize.toast($toastContent, 4000);
                        }
                    });
                    channel.bind('event-notify', function(data){
                        var notifi_element = $('span.icon-count-notifies');
                        var notifies_count = parseInt(notifi_element.text());
                        if(data.type!=undefined&&data.type!='visit') {
                            if(isNaN(notifies_count)){
                                notifi_element.text(1)
                            }else {
                                notifi_element.text(notifi_element.text() != "" ? parseInt(notifi_element.text()) + 1 : 1);
                            }
                        }

                        if(typeof data == 'object') {
                            var $toastContent = $('<div class="blue lighten-1">'+data.text+'</div>');
                        }else{
                            var $toastContent = $('<div class="blue lighten-1">You have a notification.</div>');
                        }
                        Materialize.toast($toastContent, 4000);
                    });
                    /*Pusher.log = function(msg) {
                       console.log(msg);
                    }*/
                });
            })();
        </script>
    <?php endif; ?>
<?php echo $__env->yieldSection(); ?>
<?php if(isset($_SESSION)): ?>
    <!-- flash array -->
    <script>
        <?php foreach(\McKay\Flash::all() as $flash): ?>
            <?php /*<div class="alert alert-<?php echo e($flash['type'] == 'error' ? 'danger' : $flash['type']); ?>">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo e($flash['message']); ?>

            </div>*/ ?>
            var $toastContent = $('<div class="<?php echo e($flash['type']); ?> lighten-1"><?php echo $flash['message']; ?></div>');
                Materialize.toast($toastContent, 4000);
            delete $toastContent;
        <?php endforeach; ?>
        <?php var_dump(\McKay\Flash::all())?>
    </script>
<?php endif; ?>


<?php if(session('flash')): ?>
    <!-- flash function -->
    <script>
    <?php foreach(session('flash') as $flash): ?>
        <?php if(!empty($flash['message'])): ?>
            <?php /*<div class="alert alert-<?php echo e($flash['type'] == 'error' ? 'danger' : $flash['type']); ?>">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo e($flash['message']); ?>

            </div>*/ ?>
            var $toastContent = $('<div class="<?php echo e($flash['type']); ?> lighten-1"><?php echo $flash['message']; ?></div>');
                Materialize.toast($toastContent, 4000);
        <?php endif; ?>
    <?php endforeach; ?>
    <?php session()->forget('flash');?>
    </script>
<?php endif; ?>


<?php if(!Auth::check()): ?>
    <?php if(isset($errors) && count($errors) > 0): ?>
        <script>
        <?php foreach($errors->all() as $error): ?>
            var $toastContent = $('<div class="red lighten-1">'+
                '<?php echo e($error); ?>'
                +'</div>');
            delete $toastContent;
            Materialize.toast($toastContent, 4000);
        <?php endforeach; ?>
        </script>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>