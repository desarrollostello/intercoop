<?php if(count($notifies) > 0): ?>
    <?php foreach($notifies as $key => $notify): ?>
        <?php if($notify->from()->first()->status!='1'): ?>
            <?php continue; ?>
        <?php endif; ?>
        <?php if(!empty($notify)): ?>
            <?php switch( $notify->type ):
                case  0 : ?>
                <?php /* Someone has accectp your request */ ?>
                    <li class="<?php echo e($notify->viewed == 0 ? Auth::user()->sex=="f"? "pink": "blue" : null); ?> lighten-5" data-last="<?php echo e(\Hashids::encode($notify->id)); ?>">
                        <a href="<?php echo e(route('accound', encrypt(\Pheaks\User::find($notify->user_from)->id))); ?>" class="notify-list-item element-of-message">
                            <div class="d-inline-block v-align-middle valign-wrapper">
                                <img src="<?php echo e(asset(\Pheaks\User::find($notify->user_from)->profile->avatar->small)); ?>" class="valign responsive-img circle" alt="" width="40">
                            </div>
                            <div class="d-inline-block v-align-middle">
                                <p class="value-notif truncate"><b><?php echo e(\Pheaks\User::find($notify->user_from)->user_name); ?></b> <small class="">accept your contact request.</small></p>
                                <p class="no-margin">
                                    <small class="mdc-text-grey">
                                        <i class="icon-time grey-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                                        <?php echo e($notify->created_at->diffForHumans()); ?>

                                        <i class="icon-plus-sign green-text text-lighten-1 right" style="font-size: 1rem;line-height: normal;height: initial;"></i>
                                    </small>
                                </p>
                            </div>
                        </a>
                    </li>
                    <?php break;
                case  1 : ?>
                <?php /* Someone has added you */ ?>
                    <li class="<?php echo e($notify->viewed == 0 ? Auth::user()->sex=="f"? "pink": "blue" : null); ?> lighten-5" data-last="<?php echo e(\Hashids::encode($notify->id)); ?>">
                        <a href="<?php echo e(route('accound', encrypt(\Pheaks\User::find($notify->user_from)->id))); ?>" class="notify-list-item element-of-message blue lighten-5">
                            <div class="d-inline-block v-align-middle valign-wrapper">
                                <img src="<?php echo e(asset(\Pheaks\User::find($notify->user_from)->profile->avatar->small)); ?>" class="valign responsive-img circle" alt="" width="40">
                            </div>
                            <div class="d-inline-block v-align-middle">
                                <p class="value-notif truncate"><b><?php echo e(\Pheaks\User::find($notify->user_from)->user_name); ?></b> <small class="">has sent a request contact.</small></p>
                                <p class="no-margin">
                                    <small class="mdc-text-grey">
                                        <i class="icon-time grey-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                                        <?php echo e($notify->created_at->diffForHumans()); ?>

                                        <i class="icon-plus-sign green-text text-lighten-1 right" style="font-size: 1rem;line-height: normal;height: initial;"></i>
                                    </small>
                                </p>
                            </div>
                        </a>
                    </li>
                    <?php break;
                case  3 : ?>
                <?php /* He likes someone */ ?>
                    <li class="<?php echo e($notify->viewed == 0 ? Auth::user()->sex=="f"? "pink": "blue" : null); ?> lighten-5" data-last="<?php echo e(\Hashids::encode($notify->id)); ?>">
                        <a href="<?php echo e(route('accound', encrypt(\Pheaks\User::find($notify->user_from)->id))); ?>" class="notify-list-item element-of-message">
                            <div class="d-inline-block v-align-middle valign-wrapper">
                                <img src="<?php echo e(asset(\Pheaks\User::find($notify->user_from)->profile->avatar->small)); ?>" class="valign responsive-img circle" alt="" width="40">
                            </div>
                            <div class="d-inline-block v-align-middle">
                                <p class="value-notif truncate">
                                    <b><?php echo e(\Pheaks\User::find($notify->user_from)->user_name); ?></b>
                                    <small class="">likes you.</small>
                                </p>
                                <p class="no-margin">
                                    <small class="mdc-text-grey">
                                        <i class="icon-time grey-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                                        <?php echo e($notify->created_at->diffForHumans()); ?>

                                        <i class="icon-heart <?php echo e(Auth::user()->sex=='f'?'pink-text':'blue-text'); ?> text-lighten-1 right" style="font-size: 1rem;line-height: normal;height: initial;"></i>
                                    </small>
                                </p>
                            </div>
                        </a>
                    </li>
                    <?php break;
                case  4 : ?>
                <?php /* Someone likes your photo */ ?>
                    <li class="<?php echo e($notify->viewed == 0 ? Auth::user()->sex=="f"? "pink": "blue" : null); ?> lighten-5" data-last="<?php echo e(\Hashids::encode($notify->id)); ?>">
                        <a href="<?php echo e(url(route('show-photo'))); ?>" class="notify-list-item element-of-message show-photo" data-photo-id="<?php echo e(encrypt($notify->object)); ?>">
                            <div class="d-inline-block v-align-middle valign-wrapper">
                                <img src="<?php echo e(asset(\Pheaks\User::find($notify->user_from)->profile->avatar->small)); ?>" class="valign responsive-img circle" alt="" width="40">
                            </div>
                            <div class="d-inline-block v-align-middle">
                                <p class="value-notif truncate">
                                    <b><?php echo e(\Pheaks\User::find($notify->user_from)->user_name); ?></b>
                                    <small class="">like your photo.</small>
                                </p>
                                <p class="no-margin">
                                    <small class="mdc-text-grey">
                                        <i class="icon-time grey-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                                        <?php echo e($notify->created_at->diffForHumans()); ?>

                                        <i class="icon-heart <?php echo e(Auth::user()->sex=='f'?'pink-text':'blue-text'); ?> text-lighten-1 right" style="font-size: 1rem;line-height: normal;height: initial;"></i>
                                    </small>
                                </p>
                            </div>
                        </a>
                    </li>
                    <?php break;
                case  5 : ?>
                <?php /* Someone commented on your photo */ ?>
                    <li class="<?php echo e($notify->viewed == 0 ? Auth::user()->sex=="f"? "pink": "blue" : null); ?> lighten-5" data-last="<?php echo e(\Hashids::encode($notify->id)); ?>">
                        <a href="<?php echo e(route('accound', encrypt(\Pheaks\User::find($notify->user_from)->id))); ?>" class="notify-list-item element-of-message">
                            <div class="d-inline-block v-align-middle valign-wrapper">
                                <img src="<?php echo e(asset(\Pheaks\User::find($notify->user_from)->profile->avatar->small)); ?>" class="valign responsive-img circle" alt="" width="40">
                            </div>
                            <div class="d-inline-block v-align-middle">
                                <p class="value-notif truncate">
                                    <b><?php echo e(\Pheaks\User::find($notify->user_from)->user_name); ?></b>
                                    <small class="">comment your photo.</small>
                                    <small class="mdc-text-grey d-block">
                                        <i class="icon-time grey-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                                        <?php echo e($notify->created_at->diffForHumans()); ?>

                                        <i class="icon-comment green-text text-lighten-1 right" style="font-size: 1rem;line-height: normal;height: initial;"></i>
                                    </small>
                                </p>
                            </div>
                        </a>
                    </li class="<?php echo e($notify->viewed == 0 ? "blue lighten-5" : null); ?>">
                    <?php break;
                case  6 : ?>
                <?php /* Someone has commented on your state */ ?>
                    <li class="<?php echo e($notify->viewed == 0 ? Auth::user()->sex=="f"? "pink": "blue" : null); ?> lighten-5" data-last="<?php echo e(\Hashids::encode($notify->id)); ?>">
                        <a href="<?php echo e(route('accound', encrypt(\Pheaks\User::find($notify->user_from)->id))); ?>" class="notify-list-item element-of-message">
                            <div class="d-inline-block v-align-middle valign-wrapper">
                                <img src="<?php echo e(asset(\Pheaks\User::find($notify->user_from)->profile->avatar->small)); ?>" class="valign responsive-img circle" alt="" width="40">
                            </div>
                            <div class="d-inline-block v-align-middle">
                                <p class="value-notif truncate">
                                    <b><?php echo e(\Pheaks\User::find($notify->user_from)->user_name); ?></b>
                                    <small class="">comment your state.</small>
                                </p>
                                <p class="no-margin">
                                    <small class="mdc-text-grey">
                                        <i class="icon-time time-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                                        <?php echo e($notify->created_at->diffForHumans()); ?>

                                        <i class="icon-comment green-text text-lighten-1 right" style="font-size: 1rem;line-height: normal;height: initial;"></i>
                                    </small>
                                </p>
                            </div>
                        </a>
                    </li>
                    <?php break;
                case  7 : ?>
                <?php /* Someone likes your state */ ?>
                    <li class="<?php echo e($notify->viewed == 0 ? Auth::user()->sex=="f"? "pink": "blue" : null); ?> lighten-5" data-last="<?php echo e(\Hashids::encode($notify->id)); ?>">
                        <a href="<?php echo e(route('accound', encrypt(\Pheaks\User::find($notify->user_from)->id))); ?>" class="notify-list-item element-of-message">
                            <div class="d-inline-block v-align-middle valign-wrapper">
                                <img src="<?php echo e(asset(\Pheaks\User::find($notify->user_from)->profile->avatar->small)); ?>" class="valign responsive-img circle" alt="" width="40">
                            </div>
                            <div class="d-inline-block v-align-middle">
                                <p class="value-notif truncate">
                                    <b><?php echo e(\Pheaks\User::find($notify->user_from)->user_name); ?></b>
                                    <small class="">like your state.</small>
                                </p>
                                <p class="no-margin">
                                    <small class="mdc-text-grey">
                                        <i class="icon-time grey-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                                        <?php echo e($notify->created_at->diffForHumans()); ?>

                                        <i class="icon-heart pink-text text-lighten-1 right" style="font-size: 1rem;line-height: normal;height: initial;"></i>
                                    </small>
                                </p>
                            </div>
                        </a>
                    </li>
                    <?php break;
                case  8 : ?>
                    <?php /* Someone likes your state */ ?>
                    <li class="<?php echo e($notify->viewed == 0 ? Auth::user()->sex=="f"? "pink": "blue" : null); ?> lighten-5" data-last="<?php echo e(\Hashids::encode($notify->id)); ?>">
                        <a href="<?php echo e(route('accound', encrypt(\Pheaks\User::find($notify->user_from)->id))); ?>" class="notify-list-item element-of-message">
                            <div class="d-inline-block v-align-middle valign-wrapper">
                                <img src="<?php echo e(asset(\Pheaks\User::find($notify->user_from)->profile->avatar->small)); ?>" class="valign responsive-img circle" alt="" width="40">
                            </div>
                            <div class="d-inline-block v-align-middle">
                                <p class="value-notif truncate">
                                    <b><?php echo e(\Pheaks\User::find($notify->user_from)->user_name); ?></b>
                                    <small class="">visited your profile.</small>
                                </p>
                                <p class="no-margin">
                                    <small class="mdc-text-grey">
                                        <i class="icon-time grey-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                                        <?php echo e($notify->created_at->diffForHumans()); ?>

                                        <i class="icon-user blue-text text-lighten-1 right" style="font-size: 1rem;line-height: normal;height: initial;"></i>
                                    </small>
                                </p>
                            </div>
                        </a>
                    </li>
                    <?php break;
                default: ?>
                    <li>
                        <b>The type of notification is not recognized.</b>
                    </li>
                    <?php break;
            endswitch; ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <li>
        <a>
            <p class="no-margin">You not have notifications</p>
        </a>
    </li>
<?php endif; ?>