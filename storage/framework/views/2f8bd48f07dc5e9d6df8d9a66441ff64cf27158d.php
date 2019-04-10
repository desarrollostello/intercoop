<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="section">
            <!-- Login and signup forms -->
            <div class="row">
                <div class="col s12 l6 hide-on-med-and-down">
                    <p class="black-text">Looking for someone?</p>
                    <p class="black-text">Don't miss only, encourage to meet new people.</p>
                    <p class="black-text">Three steps and you're ready.</p>
                    <h4 class="black-text">It's free!</h4>

                    <img src="<?php echo e(asset('img/responsive-website-design.png')); ?>" width="100%">
                    <div class="col s12 padding-t">
                        <?php foreach($users as $key => $user): ?>
                            <a href="<?php echo e(route('accound', encrypt($user->id))); ?>" class="col s4 center">
                                <img src="<?php echo e(asset(is_object($user->profile) ? File::exists($user->profile->avatar->medium) ? $user->profile->avatar->medium : 'img/default_avatar.png'  : 'img/default_avatar.png')); ?>" alt="avatar" width="100%" class="responsive-img circle">
                                <p class="white-text truncate tooltipped" data-position="bottom" data-tooltip="<?php echo e($user->first_name); ?> <?php echo e($user->sex == 'f' ? '<i class="icon-female pink-text"></i>' : '<i class="icon-male blue-text"></i>'); ?>" style="text-shadow: 2px 2px black;"><?php echo e($user->first_name); ?></p>
                            </a>
                        <?php endforeach; ?>
                            <div class="col s4 center">
                                <p class="white-text truncate" style="text-shadow: 2px 2px black;line-height: 5rem;">And <?php echo e(Pheaks\User::all()->count() - 5); ?> users more.</p>
                            </div>
                    </div>
                </div>
                <div class="col s12 l6 right white auth-forms">
                    <?php echo Form::open([
                        "route" => "signup",
                        "class" => (\Request::route()->getName()=='login')?"form-signup hidden ":"form-signup",
                        "id"    => "signup-form"
                    ]); ?>

                        <h4 class="center blue-text">Signup <span class="spinner-icon-hidden hidden-block" style="font-size: 18px;"><i class="icon-spinner icon-spin"></i></span></h4>
                        <div class="input-field col s12 center social-icons">
                            <a href="<?php echo e(url(route('fb-signup'))); ?>" class="fb-icon indigo darken-1 margin-lr btn btn-block" style="text-transform: lowercase;">
                                <i class="icon-facebook icon-2x"></i>acebook
                            </a>
                            <?php /*<a href="#" class="gl-icon red-text text-darken-1 margin-lr" disabled>
                                <i class="icon-google-plus-sign icon-2x"></i>
                            </a>*/ ?>
                            <!--<a href="#" class="gl-icon deep-blue-text darken-3 margin-lr" disabled>
                                <i class="icon-twitter-sign icon-2x"></i>
                            </a>-->
                        </div>
                        <div class="input-field col s12 hr-separator center">
                            <hr>
                            <span>Or</span>
                        </div>
                        <div class="input-field col s12 m6">
                            <?php echo e(Form::text('first_name', session()->has('first_name') ? session()->get('first_name') : old('first_name'), ['class'=>'validate'])); ?>

                            <?php echo e(Form::label('first_name','First Name:')); ?>

                        </div>
                        <div class="input-field col s12 m6">
                            <?php echo e(Form::text('last_name', session()->has('last_name') ? session()->get('last_name') : old('last_name'), ['class'=>'validate'])); ?>

                            <?php echo e(Form::label('last_name','Last name:')); ?>

                        </div>
                        <div class="input-field col s12">
                            <?php echo e(Form::text('user_name', session()->has('user_name') ? session()->get('user_name') : old('user_name'), ['class'=>'validate user_name'])); ?>

                            <?php echo e(Form::label('user_name','User name:')); ?>

                        </div>
                        <div class="input-field col s12">
                            <?php echo e(Form::email('email', session()->has('email') ? session()->get('email') : old('email'), ['class'=>'validate field-email'])); ?>

                            <?php echo e(Form::label('email', 'Email:')); ?>

                        </div>
                        <div class="input-field">
                            <div class="col s12" style="position: relative">
                                <?php echo e(Form::label('', 'Birthday:', ['class'=>'active'])); ?>                                
                            </div>
                            <div class="col s12 m4">
                                <?php echo e(Form::selectYear('birth_year', date('Y')-18, date('Y')-18-70, session()->has('birth_year') ? session()->get('birth_year') : old('birth_year'), ['class'=>'birth_year'])); ?>

                            </div>
                            <div class="col s12 m4">
                                <?php echo e(Form::selectMonth('birth_month', session()->has('birth_month') ? session()->get('birth_month') : old('birth_month'), ['class'=>'birth_month'])); ?>

                            </div>
                            <div class="col s12 m4">
                                <select name="birth_day" class="birth_day">
                                    <option value="" selected disabled>Day</option>
                                    <?php if(session()->has('birth_day')): ?>
                                        <option value="<?php echo e(session()->get('birth_day')); ?>"><?php echo e(session()->get('birth_day')); ?></option>
                                    <?php elseif(old('birth_day')): ?>
                                        <option value="<?php echo e(old('birth_day')); ?>"><?php echo e(old('birth_day')); ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <?php echo e(Form::password('password', null, ['class'=>'validate'])); ?>

                            <?php echo e(Form::label('password','Password:')); ?>

                        </div>
                        <div class="input-field col s12">
                            <?php echo e(Form::label('sex', 'Sex:', ['class'=>'active'])); ?>

                            <?php echo e(Form::select('sex', [
                                'f' => 'Female',
                                'm' => 'Male', 
                                'b' => 'Bisexual'], session()->has('sex') ? session()->get('sex') : old("sex"))); ?>

                        </div>
                        <div class="input-field col s12">
                            <?php echo e(Form::label('interest', 'Interests:', ['class'=>'active'])); ?>

                            <?php echo e(Form::select('interest', [
                                'f' => 'Female',
                                'm' => 'Male', 
                                'b' => 'Bisexual'], old("interest"))); ?>

                        </div>
                        <div class="input-filed col s12 m6 l12 margin-t">                        
                            <button class="btn waves-effect waves-light blue col s12" type="submit" name="submit-action">
                                Signup
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                        <div class="input-field col s12 m6 l12 center padding-b">
                            <div class="waves-light btn-flat col s12">
                                <span>Already have an account?</span> <a href="#" class="show-login-form">Login</a>
                            </div>
                        </div>
                    <?php echo Form::close(); ?>

                    <?php echo Form::open([
                        "route"   => "login",
                        "class" => (\Request::route()->getName()!='login')?"form-login hidden ":"form-login",
                    ]); ?>

                        <h4 class="center blue-text">Login</h4>
                        <div class="input-field col s12 center social-icons">
                            <a href="<?php echo e(url(route('fb-login'))); ?>" class="fb-icon indigo darken-1 margin-lr btn btn-block" style="text-transform: lowercase;">
                                <i class="icon-facebook icon-2x"></i>acebook
                            </a>
                            <?php /*<a href="<?php echo e(url(route('gle-login'))); ?>" class="gl-icon red-text text-darken-1 margin-lr" disabled>
                                <i class="icon-google-plus-sign icon-2x"></i>
                            </a>*/ ?>
                        </div>
                        <div class="input-field col s12 hr-separator center">
                            <hr>
                            <span>Or</span>
                        </div>
                        <div class="input-field col s12">
                            <?php echo e(Form::text('email', session()->has('email') ? session()->get('email') : old('email'), ['id'=>'login_email'])); ?>

                            <?php echo e(Form::label('login_email', 'Email or Username:')); ?>

                        </div>
                        <div class="input-field col s12">
                            <?php echo e(Form::password('password', ['id'=>'login_password'])); ?>

                            <?php echo e(Form::label('login_password', 'Password')); ?>

                        </div>
                        <div class="input-field col s12 m6 no-padding center">
                            <?php echo e(Form::checkbox('remember_me', old('remember_me'), null, ['id'=>'remember_me'])); ?>

                            <?php echo e(Form::label('remember_me', 'Remember me', ['style'=>'margin: 0 0 20px 0'])); ?>

                        </div>
                        <div class="input-field col s12 m6 center">
                            <div class="margin">
                                <a href="#" class="forgot-password">
                                    Forgot password?
                                </a>
                            </div>
                        </div>
                        <div class="input-filed col s12 m6 l12 margin-t">                        
                            <button class="btn waves-effect waves-light blue col s12" type="submit" name="login-action">
                                Login
                            </button>
                        </div>
                        <div class="input-field col s12 m6 l12 center padding-b">
                            <a href="#" class="show-signup-form waves-light btn-flat col s12">
                                Signup
                            </a>
                        </div>
                    <?php echo Form::close(); ?>

                </div>
                <div class="col s12 l6 hide-on-large-only">
                    <p class="black-text">Looking for someone?</p>
                    <p class="black-text">Don't miss only, encourage to meet new people.</p>
                    <p class="black-text">Three steps and you're ready.</p>
                    <h4 class="black-text">It's free!</h4>
                    <!--<img src="<?php echo e(asset('img/responsive-website-design.png')); ?>" width="100%">-->
                    <div class="col s12 padding-t">
                        <?php foreach($users as $key => $user): ?>
                            <a href="<?php echo e(route('accound', encrypt($user->id))); ?>" class="col s6 m4 center tooltipped" data-position="bottom" data-tooltip="<?php echo e($user->first_name." ".$user->first_name); ?> <?php echo e($user->sex == 'f' ? '<i class="icon-female pink-text"></i>' : '<i class="icon-male blue-text"></i>'); ?>" >
                                <img src="<?php echo e(asset(is_object($user->profile) ? File::exists($user->profile->avatar->medium) ? $user->profile->avatar->medium : 'img/default_avatar.png'  : 'img/default_avatar.png')); ?>" alt="avatar" width="100%" class="responsive-img circle">
                                <p class="white-text truncate" style="text-shadow: 2px 2px black;"><?php echo e($user->first_name); ?></p>
                            </a>
                        <?php endforeach; ?>
                            <div class="col s6 m4 center">
                                <p class="white-text truncate" style="text-shadow: 2px 2px black;line-height: 10rem;">And <?php echo e(Pheaks\User::all()->count() - 5); ?> users more.</p>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hide-on-med-and-down center">

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-javascripts'); ?>
    @parent
    <script>
        $(function(){
            var validate_signup_form;
            //Validate if ecists the email for signup
            $('.field-email').keyup(function(){
                var element = $(this);
                var value = element.val();

                $.ajax({
                    url:    '<?php echo e(route('existsemail')); ?>',
                    method: 'POST',
                    data: {_token:$('#application-token').data('token'),email:value},
                    beforeSend: function(){
                        $('.spinner-icon-hidden').removeClass('hidden-block');
                    },
                    success: function(response){
                        $('.spinner-icon-hidden').addClass('hidden-block');
                        status = parseInt(response);
                        if(status==1){
                            element.css({
                                'border-bottom': '1px solid #F44336',
                                'box-shadow': '0 1px 0 0 #F44336'
                            });
                            var $toastContent = $('<div class="red lighten-1">email already been used.</div>');
                            Materialize.toast($toastContent, 4000);
                            validate_signup_form = false;
                        }else{
                            element.removeAttr('style');
                            validate_signup_form = true;
                        }
                    }
                }).statusCode({
                    500: function(){
                        Materialize.toast('Permision denied');
                    }
                });
            });
            $('.user_name').keyup(function(){
                var element = $(this);
                var value = element.val();

                $.ajax({
                    url:    '<?php echo e(route('existsusername')); ?>',
                    method: 'POST',
                    data: {_token:$('#application-token').data('token'),user:value},
                    beforeSend: function(){
                        $('.spinner-icon-hidden').removeClass('hidden-block');
                    },
                    success: function(response){
                        $('.spinner-icon-hidden').addClass('hidden-block');
                        status = parseInt(response);
                        if(status==1){
                            element.css({
                                'border-bottom': '1px solid #F44336',
                                'box-shadow': '0 1px 0 0 #F44336'
                            });
                            var $toastContent = $('<div class="red lighten-1">username already been used</div>');
                            Materialize.toast($toastContent, 4000);
                            validate_signup_form = false;
                        }else{
                            element.removeAttr('style');
                            validate_signup_form = true;
                        }
                    }
                }).statusCode({
                    500: function(){
                        Materialize.toast('Permision denied');
                    }
                });
            });
            $('#signup-form').submit(function(){
                if(validate_signup_form==false){
                    console.log('Invalida form content');
                    return false;
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>