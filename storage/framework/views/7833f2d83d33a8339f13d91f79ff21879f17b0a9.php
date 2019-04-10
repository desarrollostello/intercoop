<?php $__env->startSection('content'); ?>
    <div class="container row">
        <div class="col l4 hide-on-med-and-down aside-left-menu no-padding padding-r">
            <div class="collection white">
                <!-- Aside menu left -->
                <?php echo $__env->make('includes.aside-menu-left', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <!-- End aside menu left -->
            </div>
        </div>
        <div class="col s12 l8 no-padding mmargin-t">
            <?php if(isset($user) && $user != null): ?>
                <div class="col s12 white border-thin">
                <div class="col s12 no-padding margin-b">
                    <div class="center">
                        <div class="col s12">
                            <div class="col s12 m4 mmargin-tb">
                                <?php if(\File::exists($user->profile->avatar->medium)): ?>
                                    <a href="<?php echo e(url(route('show-photo'))); ?>" class="show-photo" data-photo-id="<?php echo e(encrypt($user->profile->avatar->id)); ?>">
                                        <img src="<?php echo e(asset($user->profile->avatar->medium)); ?>" class="responsive-img circle z-depth-1 profile-avatar-large">
                                    </a>
                                <?php else: ?>
                                    <a>
                                        <img src="<?php echo e(asset('img/photo_unavailable.jpg')); ?>" alt="image-not-found" class="responsive-img circle z-depth-1 profile-avatar-large">
                                    </a>
                                <?php endif; ?>
                                <p class="no-margin"><?php echo e($user->user_name); ?></p>
                                <p class="no-margin">
                                    <small><?php echo e($user->first_name ." ". $user->last_name); ?></small>
                                </p>
                            </div>
                            <div class="col s12 m8 mmargin-tb">
                                <div class="">
                                    <div class="col s12 no-padding border-thin">
                                        <div class="d-block">
                                            <a class="left padding center col s6 light-blue lighten-1 white-text" style="border-right: thin solid #e0e0e0">
                                                <p class="no-padding no-margin flow-text">
                                                    <span>
                                                        <?php echo e(\Pheaks\Contacts::where('user_from',$user->id)
                                                        ->orWhere('user_to',$user->id)
                                                        ->where('status','1')->get()->count()); ?>

                                                    </span>
                                                </p>
                                                <p class="no-padding no-margin">
                                                    <i class="material-icons">person_add</i> <span>Contacts</span>
                                                </p>
                                            </a>
                                            <a class="right padding center col s6 light-blue lighten-1 white-text">
                                                <p class="no-padding no-margin flow-text">
                                                    <span>
                                                        <?php echo e($user->likes()->count()); ?>

                                                    </span>
                                                </p>
                                                <p class="no-padding no-margin">
                                                    <i class="material-icons">star</i> <span>Likes</span>
                                                </p>
                                            </a>
                                        </div>
                                        <div class="d-block">
                                            <div class="padding col s12 grey lighten-5 left-align">
                                                <p class="no-margin">
                                                    <b>State:</b>
                                                </p>
                                                <p class="no-margin mmargin-t">
                                                    <?php if(\Pheaks\State::where(['user_id'=>$user->id,'privacy'=>'1','status'=>'1'])->orderBy('created_at','desc')->first()!=null): ?>
                                                        <?php echo str_limit(\Pheaks\State::where(['user_id'=>$user->id,'privacy'=>'1','status'=>'1'])->orderBy('created_at','desc')->first()->state, $limit = 50, $end = ' ... <a href="">More</a>'); ?>

                                                    <?php else: ?>
                                                        Not defined
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 no-padding">
                            <?php if(Checks::is_contact($user->id)): ?>
                                <div class="col s12 m4 l4 margin-t">
                                    <a href="<?php echo e(route('messages-user', encrypt($user->id))); ?>" class="waves-effect blue waves-light btn d-block tooltipped no-padding" data-position="top" data-tooltip="Message <i class='icon-envelope blue-text lighteen-2'></i>" id="sen-contact-message">
                                        <span class="hide-on-small-only">Message</span> <i class="icon-envelope"></i>
                                    </a>
                                </div>
                                <div class="col s12 m4 l4 margin-t">
                                    <?php if(Checks::is_liked('user',$user->id)): ?>
                                        <button class="waves-effect pink waves-light btn d-block tooltipped disabled" data-position="top" data-tooltip="Like <i class='icon-heart pink-text lighteen-1'></i>">
                                            <span class="hide-on-small-only">Like</span> <i class="icon-heart"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="waves-effect pink waves-light btn d-block tooltipped add-like-user" data-position="top" data-tooltip="Like <i class='icon-heart pink-text lighteen-1'></i>">
                                            <span class="hide-on-small-only">Like</span> <i class="icon-heart"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                                <div class="col s12 m4 l4 margin-t">
                                    <?php if(Checks::contact_request_sended($user->id)): ?>
                                        <button class="waves-effect red waves-light btn d-block tooltipped cancel-contact-button" data-position="top" data-tooltip="Cancel Request <i class='icon-remove red-text text-lighteen-1'></i>">
                                            <span class="hide-on-small-only">Cancel</span> <i class="icon-remove"></i>
                                        </button>
                                    <?php elseif(Checks::contact_is_request($user->id)): ?>
                                        <button class="waves-effect blue waves-light btn d-block tooltipped acept-contact-button" data-position="top" data-tooltip="Acept Request <i class='icon-ok blue-text text-lighteen-1'></i>">
                                            <span class="hide-on-small-only">Acept</span> <i class="icon-ok"></i>
                                        </button>
                                    <?php elseif(Checks::is_contact($user->id)): ?>
                                        <button class="waves-effect red waves-light btn d-block tooltipped delete-contact-button" data-position="top" data-tooltip="Delete Contact <i class='icon-minus red-text text-lighteen-1'></i>">
                                            <span class="hide-on-small-only">Delete</span> <i class="icon-minus"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="waves-effect green waves-light btn d-block tooltipped add-contact-button" data-position="top" data-tooltip="Add Contact <i class='icon-plus green-text text-lighteen-1'></i>">
                                            <span class="hide-on-small-only">Add</span> <i class="icon-plus"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="col s12 m6 margin-t">
                                    <?php if(Checks::is_liked('user',$user->id)): ?>
                                        <button class="waves-effect pink waves-light btn d-block tooltipped disabled" data-position="top" data-tooltip="Like <i class='icon-heart pink-text lighteen-1'></i>">
                                            <span class="hide-on-small-only">Like</span> <i class="icon-heart"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="waves-effect pink waves-light btn d-block tooltipped add-like-user" data-position="top" data-tooltip="Like <i class='icon-heart pink-text lighteen-1'></i>">
                                            <span class="hide-on-small-only">Like</span> <i class="icon-heart"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                                <div class="col s12 m6 margin-t">
                                    <?php if(Checks::contact_request_sended($user->id)): ?>
                                        <button class="waves-effect red waves-light btn d-block tooltipped cancel-contact-button" data-position="top" data-tooltip="Cancel Request <i class='icon-remove red-text text-lighteen-1'></i>">
                                            <span class="hide-on-small-only">Cancel</span> <i class="icon-remove"></i>
                                        </button>
                                    <?php elseif(Checks::contact_is_request($user->id)): ?>
                                        <button class="waves-effect blue waves-light btn d-block tooltipped acept-contact-button" data-position="top" data-tooltip="Acept Request <i class='icon-ok blue-text text-lighteen-1'></i>">
                                            <span class="hide-on-small-only">Acept</span> <i class="icon-ok"></i>
                                        </button>
                                    <?php elseif(Checks::is_contact($user->id)): ?>
                                        <button class="waves-effect red waves-light btn d-block tooltipped delete-contact-button" data-position="top" data-tooltip="Delete Contact <i class='icon-minus red-text text-lighteen-1'></i>">
                                            <span class="hide-on-small-only">Delete</span> <i class="icon-minus"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="waves-effect green waves-light btn d-block tooltipped add-contact-button" data-position="top" data-tooltip="Add Contact <i class='icon-plus green-text text-lighteen-1'></i>">
                                            <span class="hide-on-small-only">Add</span> <i class="icon-plus"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php /* <?php if(Checks::is_contact($user->id)): ?>
                <div class="col s12 mmargin-tb">
                    <form action="#">
                        <div class="input-field col s12">
                            <textarea id="textarea1" class="materialize-textarea message-to-contact counter" length="200"></textarea>
                            <label for="textarea1">Send message</label>
                        </div>
                        <div class="input-field col s12">
                            <a href="#" type="submit" class="btn btn-sm btn-block blue lighten-1 button-to-submit-message">Send <i class="material-icons">SEND</i></a>
                        </div>
                    </form>
                </div>
                <?php endif; ?>*/ ?>
                </div>

                <div class="col s12 white mmargin-t border-thin">
                <h4>Photos</h4>
                <div class="slider">
                    <div class="viewer">
                        <?php if(isset($users_images) && !empty($users_images)&&$users_images->count()>0): ?>
                            <?php foreach($users_images as $key => $image): ?>
                                <div id="user-image-<?php echo e($key); ?>" class="col s12 m4 l3 viewer-image center mmargin-t">
                                    <?php if(\File::exists($image->medium)): ?>
                                        <a href="<?php echo e(url(route('show-photo'))); ?>" class="show-photo" data-photo-id="<?php echo e(encrypt($image->id)); ?>">
                                            <?php /*<img src="<?php echo e(asset($image->medium)); ?>" class="z-depth-1 img-responsive profile-image" />*/ ?>
                                                <div class="backgroun-avatar-user-image" style="background-image: url('<?php echo e(asset($image->medium)); ?>');background-size:cover;background-repeat:no-repeat;background-position:center center;width: 100%;height: 7rem;"></div>
                                        </a>
                                    <?php else: ?>
                                        <a data-photo-id="<?php echo e(encrypt($image->id)); ?>">
                                            <img src="<?php echo e(asset('img/photo_unavailable.jpg')); ?>" alt="image-not-found" class="z-depth-1 responsive-img">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <h3 class="center">Nothing to show</h3>
                        <?php endif; ?>
                        <?php /* Sisez image = epic | bigger | normal | mini */ ?>
                    </div>
                </div>
            </div>
            <?php else: ?>
               <div class="col s12 white border-thin">
                   <h5>User Not found</h5>
               </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php if(isset($user) && $user != null): ?>
    <?php $__env->startSection('main-javascripts'); ?>
        @parent
        <?php echo $__env->make('javascripts.user-actions-buttons', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('javascripts.content-interactivity', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php $__env->stopSection(); ?>
<?php endif; ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>