<?php if(isset($feeds)&&!empty($feeds)): ?>

    <?php foreach($feeds as $key => $feed): ?>
        <?php switch($feed->type):
            case 0: ?>
                <?php if(\Pheaks\State::find($feed->object)->status!=1 || \Pheaks\State::find($feed->object)->privacy!=1): ?>
                    <?php continue; ?>
                <?php endif; ?>
                <article class="my-timeline-block margin-t z-depth-1" data-article="<?php echo e(Hashids::encode($feed->feed_id)); ?>">
                    <div class="article-marker"></div>
                    <div class="card">
                        <div class="card-content">
                            <div class="article-user-image">
                                <a href="<?php echo e($feed->user_id==Auth::user()->id ? url(route('profile')) : url(route('accound',encrypt($feed->user_id)))); ?>" class="valign-wrapper">
                                    <?php if(!File::exists($feed->small)): ?>
                                        <img src="<?php echo e(asset('img/default_avatar.png')); ?>" width="50" alt="image-not-found" class="responsive-img circle">&nbsp;
                                    <?php else: ?>
                                        <img src="<?php echo e(asset($feed->small)); ?>" alt="" width="50" class="responsive-img circle">&nbsp;&nbsp;&nbsp;
                                    <?php endif; ?>
                                    <span class="valign"> <?php echo e($feed->user_name); ?></span>
                                </a>
                                <a class='dropdown-button user-search-button-extra-options blue-grey lighten-5 d-inline-block v-align-middle hoverable border-thin' href='#' data-activates='feed-article-n_<?php echo e($key); ?>'><i class="icon-angle-down"></i></a>
                            <?php if($feed->user_id==Auth::user()->id): ?>
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_<?php echo e($key); ?>' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Eliminar <i class="icon-remove red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                            <?php else: ?>
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_<?php echo e($key); ?>' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Reportar \ Bloquear <i class="icon-flag red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <p class="mpadding-tb"><?php if($feed->user_id==Auth::user()->id): ?> I updated my <?php else: ?><b><?php echo e($feed->user_name); ?></b> updated your <?php endif; ?> state.</p>
                            <div class="no-padding left">
                                <p class="grey-text margin-b"><?php echo e(\Pheaks\State::find($feed->object)->state); ?></p>
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="#" class="mpadding <?php echo e(\Pheaks\Http\Libraries\Checks::is_liked('state',$feed->object) ? 'dislike-state-button blue-text' : 'like-state-button grey-text'); ?> text-lighten-1" data-state="<?php echo e(encrypt($feed->object)); ?>">
                                <i class="icon-heart"></i> <span class="like-count"><?php echo e(!empty(\Pheaks\State::find($feed->object)->likes) ? \Pheaks\State::find($feed->object)->likes()->where('status','1')->count() : '0'); ?></span>
                            </a>
                            <a href="#" class="blue-text text-lighten-1 icon-comment-button" data-form="comment-form-<?php echo e($key); ?>">
                                <i class="icon-comment"></i> <?php echo e(\Pheaks\State::find($feed->object)->comments()->count()); ?>

                            </a>
                            <span class="cd-date right">
                                                <small><i class="icon-time"></i> <?php echo e($feed->created_at->diffForHumans()); ?></small>
                                            </span>
                        </div>
                        <div class="row no-margin">
                            <div class="col s12" id="comment-form-<?php echo e($key); ?>" style="display: none;">
                                <?php echo Form::open(['route'=>'commentphoto','class'=>'comment-photo-form']); ?>

                                <div class="input-field col s12 no-padding">
                                    <textarea id="input-comment-<?php echo e($key); ?>" class="materialize-textarea no-padding" name="comment_photo_text"></textarea>
                                    <label for="input-comment-<?php echo e($key); ?>">Write comment...</label>
                                </div>
                                <div class="col s12">
                                    <button type="submit" class="btn btn-block waves-light blue full-width">
                                        <i class="material-icons">send</i>
                                    </button>
                                </div>
                                <input type="hidden" name="content_elment" value="<?php echo e(encrypt($feed->object)); ?>">
                                <?php echo Form::close(); ?>

                            </div>
                            <?php if(!empty(\Pheaks\State::find($feed->object)->comments)): ?>
                                <div class="col s12 commnets-<?php echo e($key); ?>" style="border-bottom: 1px solid #ececec;border-top: 1px solid #ececec;">
                                    <?php foreach(\Pheaks\State::find($feed->object)->comments()->orderBy('id','desc')->limit(3)->get() as $comment_key => $comment): ?>
                                        <div class="col s12 no-padding mpadding-tb comment-last" data-last="<?php echo e(Hashids::encode($comment->id)); ?>">
                                            <div>
                                                <div class="row valign-wrapper no-margin">
                                                    <div class="col s1 no-padding" style="line-height:.5rem;">
                                                        <a href="<?php echo e(route('accound', encrypt($comment->user->id))); ?>">
                                                            <img src="<?php echo e(asset($comment->user->profile->avatar->small)); ?>" width="35" alt="avatar" class="circle profile-image" />&nbsp;
                                                        </a>
                                                    </div>
                                                    <div class="col s11 no-padding mpadding-l">
                                                        <a href="<?php echo e(route('accound', encrypt($comment->user->id))); ?>">
                                                            <span class="truncate blue-text text-lighten-1"><?php echo e($comment->user->user_name); ?></span>
                                                        </a>
                                                        <small class="grey-text d-block"><i class="icon-time"></i> <?php echo e($comment->created_at->diffForHumans()); ?></small>
                                                    </div>
                                                </div>
                                                <p class="no-margin mmargin-b">
                                                    <?php echo e($comment->comment); ?>

                                                    <?php /*
                                                    <?php if($comment->file_id != null): ?>
                                                        <p class="no-margin">
                                                            <img src="<?php echo e(Pheaks\Photo::find($comment->file_id )->small); ?>" alt="">
                                                        </p>
                                                    <?php endif; ?>
                                                    */ ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if(\Pheaks\State::find($feed->object)->comments()->count()>3): ?>
                                    <div class="col s12 no-padding center">
                                        <a href="#" class="padding block morefeedcomments" data-type="<?php echo e(Hashids::encode($feed->type)); ?>" data-object="<?php echo e(Hashids::encode($feed->object)); ?>" data-comments="commnets-<?php echo e($key); ?>">
                                            <span>Show more comments</span>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div> <!-- cd-timeline-content -->
                </article> <!-- cd-timeline-block -->
                <?php break;
            case  1 : ?>
                <?php if(\Pheaks\Photo::find($feed->object)->status!=1 || \Pheaks\Photo::find($feed->object)->privacy!=1): ?>
                    <?php continue; ?>
                <?php endif; ?>
                <article class="my-timeline-block margin-t z-depth-1" data-article="<?php echo e(Hashids::encode($feed->feed_id)); ?>">
                    <div class="article-marker"></div>
                    <div class="card">
                        <div class="card-content">
                            <div class="article-user-image">
                                <a href="<?php echo e($feed->user_id==Auth::user()->id ? url(route('profile')) : url(route('accound',encrypt($feed->user_id)))); ?>" class="valign-wrapper">
                                    <?php if(!File::exists($feed->small)): ?>
                                        <img src="<?php echo e(asset('img/default_avatar.png')); ?>" width="50" alt="image-not-found" class="responsive-img circle">&nbsp;
                                    <?php else: ?>
                                        <img src="<?php echo e(asset($feed->small)); ?>" alt="" width="50" class="responsive-img circle">&nbsp;&nbsp;&nbsp;
                                    <?php endif; ?>
                                    <span class="valign"> <?php echo e($feed->user_name); ?></span>
                                </a>
                                <a class='dropdown-button user-search-button-extra-options blue-grey lighten-5 d-inline-block v-align-middle hoverable border-thin' href='#' data-activates='feed-article-n_<?php echo e($key); ?>'><i class="icon-angle-down"></i></a>
                            <?php if($feed->user_id==Auth::user()->id): ?>
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_<?php echo e($key); ?>' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Eliminar <i class="icon-remove red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                            <?php else: ?>
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_<?php echo e($key); ?>' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Reportar \ Bloquear <i class="icon-flag red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <p class="mpadding-tb"><?php if($feed->user_id==Auth::user()->id): ?> <?php echo e(trans('home_page.update_my_avtar')); ?> <?php else: ?> <?php echo trans('home_page.update_your_avatar',['user_name'=>$feed->user_name]); ?> <?php endif; ?> <?php echo e(trans('home_page.complete_avatar_label')); ?></p>
                            <div class="no-padding center">
                                <?php if(!File::exists(\Pheaks\Photo::select(['original','large','medium','small'])->where('id','=', $feed->object)->first()->medium)): ?>
                                    <img src="<?php echo e(asset('img/photo_unavailable.jpg')); ?>" alt="image-not-found" class="responsive-img valign-wrapper">
                                <?php else: ?>
                                    <a href="<?php echo e(url(route('show-photo'))); ?>" class="show-photo" data-photo-id="<?php echo e(encrypt($feed->object)); ?>">
                                        <img src="<?php echo e(asset(\Pheaks\Photo::select(['original','large','medium','small'])->where('id','=', $feed->object)->first()->medium )); ?>" alt="avatar-large" class="responsive-img">
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="card-action">
                                <a href="#" class="mpadding <?php echo e(\Pheaks\Http\Libraries\Checks::is_liked('photo',$feed->object) ? ' dislike-photo-button blue-text' : ' like-photo-button grey-text'); ?> text-lighten-1" data-photo="<?php echo e(encrypt($feed->object)); ?>">
                                    <i class="icon-heart"></i> <span class="like-count"><?php echo e(!empty(\Pheaks\Photo::find($feed->object)->likes) ? \Pheaks\Photo::find($feed->object)->likes()->where('status','1')->count() : '0'); ?></span>
                                </a>
                                <a href="#" class="blue-text text-lighten-1 icon-comment-button" data-form="comment-form-<?php echo e($key); ?>">
                                    <i class="icon-comment"></i> <?php echo e(\Pheaks\Photo::find($feed->object)->comments()->count()); ?>

                                </a>
                                <span class="cd-date right">
                                                    <small class="created_at" data-created="<?php echo e($feed->created_at); ?>"><i class="icon-time"></i> <?php echo e($feed->created_at->diffForHumans()); ?></small>
                                                </span>
                            </div>
                            <div class="row no-margin">
                                <div class="col s12" id="comment-form-<?php echo e($key); ?>" style="display: none;">
                                    <?php echo Form::open(['route'=>'commentphoto','class'=>'comment-photo-form']); ?>

                                    <div class="input-field col s12 no-padding">
                                        <textarea id="input-comment-<?php echo e($key); ?>" class="materialize-textarea no-padding" name="comment_photo_text"></textarea>
                                        <label for="input-comment-<?php echo e($key); ?>">Write comment...</label>
                                    </div>
                                    <div class="col s12">
                                        <button type="submit" class="btn btn-block waves-light blue full-width">
                                            <i class="material-icons">send</i>
                                        </button>
                                    </div>
                                    <input type="hidden" name="content_elment" value="<?php echo e(encrypt($feed->object)); ?>">
                                    <?php echo Form::close(); ?>

                                </div>
                                <?php if(!empty(\Pheaks\Photo::find($feed->object)->comments)): ?>
                                    <div class="col s12 commnets-<?php echo e($key); ?>" style="border-bottom: 1px solid #ececec;border-top: 1px solid #ececec;">
                                        <?php foreach(\Pheaks\Photo::find($feed->object)->comments()->orderBy('id','desc')->limit(3)->get() as $comment_key => $comment): ?>
                                            <div class="col s12 no-padding mpadding-tb comment-last" data-last="<?php echo e(Hashids::encode($comment->id)); ?>">
                                                <div>
                                                    <div class="row valign-wrapper no-margin">
                                                        <div class="col s1 no-padding" style="line-height:.5rem;">
                                                            <a href="<?php echo e(route('accound', encrypt($comment->user->id))); ?>">
                                                                <img src="<?php echo e(asset($comment->user->profile->avatar->small)); ?>" width="35" alt="avatar" class="circle profile-image" />&nbsp;
                                                            </a>
                                                        </div>
                                                        <div class="col s11 no-padding mpadding-l">
                                                            <a href="<?php echo e(route('accound', encrypt($comment->user->id))); ?>">
                                                                <span class="truncate blue-text text-lighten-1"><?php echo e($comment->user->user_name); ?></span>
                                                            </a>
                                                            <small class="grey-text d-block"><i class="icon-time"></i> <?php echo e($comment->created_at->diffForHumans()); ?></small>
                                                        </div>
                                                    </div>
                                                    <p class="no-margin mmargin-b">
                                                        <?php echo e($comment->comment); ?>

                                                        <?php /*
                                                        <?php if($comment->file_id != null): ?>
                                                            <p class="no-margin">
                                                                <img src="<?php echo e(Pheaks\Photo::find($comment->file_id )->small); ?>" alt="">
                                                            </p>
                                                        <?php endif; ?>
                                                        */ ?>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php if(\Pheaks\Photo::find($feed->object)->comments()->count()>3): ?>
                                        <div class="col s12 no-padding center">
                                            <a href="#" class="padding block morefeedcomments" data-type="<?php echo e(Hashids::encode($feed->type)); ?>" data-object="<?php echo e(Hashids::encode($feed->object)); ?>" data-comments="commnets-<?php echo e($key); ?>">
                                                <span>Show more comments</span>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div> <!-- cd-timeline-content -->
                </article> <!-- cd-timeline-block -->
                <?php break;
            case 2: ?>
                <article class="my-timeline-block margin-t z-depth-1" data-article="<?php echo e(Hashids::encode($feed->feed_id)); ?>">
                    <div class="article-marker"></div>
                    <div class="card">
                        <div class="card-content">
                            <div class="article-user-image">
                                <a href="<?php echo e($feed->user_id==Auth::user()->id ? url(route('profile')) : url(route('accound',encrypt($feed->user_id)))); ?>" class="valign-wrapper">
                                    <?php if(!File::exists($feed->small)): ?>
                                        <img src="<?php echo e(asset('img/default_avatar.png')); ?>" width="50" alt="image-not-found" class="responsive-img circle">&nbsp;
                                    <?php else: ?>
                                        <img src="<?php echo e(asset($feed->small)); ?>" alt="" width="50" class="responsive-img circle">&nbsp;&nbsp;&nbsp;
                                    <?php endif; ?>
                                    <span class="valign"> <?php echo e($feed->user_name); ?></span>
                                </a>
                                <a class='dropdown-button user-search-button-extra-options blue-grey lighten-5 d-inline-block v-align-middle hoverable border-thin' href='#' data-activates='feed-article-n_<?php echo e($key); ?>'><i class="icon-angle-down"></i></a>
                            <?php if($feed->user_id==Auth::user()->id): ?>
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_<?php echo e($key); ?>' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Eliminar <i class="icon-remove red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                            <?php else: ?>
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_<?php echo e($key); ?>' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Reportar \ Bloquear <i class="icon-flag red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <p class="mpadding-tb"><?php if($feed->user_id==Auth::user()->id): ?> <?php echo e(trans('home_page.update_my_avtar')); ?> <?php else: ?> <?php echo trans('home_page.update_your_avatar',['user_name'=>$feed->user_name]); ?> <?php endif; ?> <?php echo e(trans('home_page.complete_avatar_label')); ?></p>
                            <div class="no-padding center">
                                <?php if(!File::exists(\Pheaks\Photo::select(['original','large','medium','small'])->where('id','=', $feed->object)->first()->large)): ?>
                                    <img src="<?php echo e(asset('img/photo_unavailable.jpg')); ?>" alt="image-not-found" class="responsive-img valign-wrapper">
                                <?php else: ?>
                                    <a href="<?php echo e(url(route('show-photo'))); ?>" class="show-photo" data-photo-id="<?php echo e(encrypt($feed->object)); ?>">
                                        <img src="<?php echo e(asset(\Pheaks\Photo::select(['original','large','medium','small'])->where('id','=', $feed->object)->first()->large )); ?>" alt="avatar-large" class="responsive-img">
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="#" class="mpadding <?php echo e(\Pheaks\Http\Libraries\Checks::is_liked('photo',$feed->object) ? ' dislike-photo-button blue-text' : ' like-photo-button grey-text'); ?> text-lighten-1" data-photo="<?php echo e(encrypt($feed->object)); ?>">
                                <i class="icon-heart"></i> <span class="like-count"><?php echo e(!empty(\Pheaks\Photo::find($feed->object)->likes) ? \Pheaks\Photo::find($feed->object)->likes()->where('status','1')->count() : '0'); ?></span>
                            </a>
                            <a href="#" class="blue-text text-lighten-1 icon-comment-button" data-form="comment-form-<?php echo e($key); ?>">
                                <i class="icon-comment"></i> <?php echo e(\Pheaks\Photo::find($feed->object)->comments()->count()); ?>

                            </a>
                            <span class="cd-date right">
                                                    <small class="created_at" data-created="<?php echo e($feed->created_at); ?>"><i class="icon-time"></i> <?php echo e($feed->created_at->diffForHumans()); ?></small>
                                                </span>
                        </div>
                        <div class="row no-margin">
                            <div class="col s12" id="comment-form-<?php echo e($key); ?>" style="display: none;">
                                <?php echo Form::open(['route'=>'commentphoto','class'=>'comment-photo-form']); ?>

                                <div class="input-field col s12 no-padding">
                                    <textarea id="input-comment-<?php echo e($key); ?>" class="materialize-textarea no-padding" name="comment_photo_text"></textarea>
                                    <label for="input-comment-<?php echo e($key); ?>">Write comment...</label>
                                </div>
                                <div class="col s12">
                                    <button type="submit" class="btn btn-block waves-light blue full-width">
                                        <i class="material-icons">send</i>
                                    </button>
                                </div>
                                <input type="hidden" name="content_elment" value="<?php echo e(encrypt($feed->object)); ?>">
                                <?php echo Form::close(); ?>

                            </div>
                            <?php if(!empty(\Pheaks\Photo::find($feed->object)->comments)): ?>
                                <div class="col s12 commnets-<?php echo e($key); ?>" style="border-bottom: 1px solid #ececec;border-top: 1px solid #ececec;">
                                    <?php foreach(\Pheaks\Photo::find($feed->object)->comments()->orderBy('id','desc')->limit(3)->get() as $comment_key => $comment): ?>
                                        <div class="col s12 no-padding mpadding-tb comment-last" data-last="<?php echo e(Hashids::encode($comment->id)); ?>">
                                            <div>
                                                <div class="row valign-wrapper no-margin">
                                                    <div class="col s1 no-padding" style="line-height:.5rem;">
                                                        <a href="<?php echo e(route('accound', encrypt($comment->user->id))); ?>">
                                                            <img src="<?php echo e(asset($comment->user->profile->avatar->small)); ?>" width="35" alt="avatar" class="circle profile-image" />&nbsp;
                                                        </a>
                                                    </div>
                                                    <div class="col s11 no-padding mpadding-l">
                                                        <a href="<?php echo e(route('accound', encrypt($comment->user->id))); ?>">
                                                            <span class="truncate blue-text text-lighten-1"><?php echo e($comment->user->user_name); ?></span>
                                                        </a>
                                                        <small class="grey-text d-block"><i class="icon-time"></i> <?php echo e($comment->created_at->diffForHumans()); ?></small>
                                                    </div>
                                                </div>
                                                <p class="no-margin mmargin-b">
                                                    <?php echo e($comment->comment); ?>

                                                    <?php /*
                                                    <?php if($comment->file_id != null): ?>
                                                        <p class="no-margin">
                                                            <img src="<?php echo e(Pheaks\Photo::find($comment->file_id )->small); ?>" alt="">
                                                        </p>
                                                    <?php endif; ?>
                                                    */ ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if(\Pheaks\Photo::find($feed->object)->comments()->count()>3): ?>
                                    <div class="col s12 no-padding center">
                                        <a href="#" class="padding block morefeedcomments" data-type="<?php echo e(Hashids::encode($feed->type)); ?>" data-object="<?php echo e(Hashids::encode($feed->object)); ?>" data-comments="commnets-<?php echo e($key); ?>">
                                            <span>Show more comments</span>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div> <!-- cd-timeline-content -->
                </article> <!-- cd-timeline-block -->
                <?php break;
            case 3: ?>
                <article class="my-timeline-block margin-t z-depth-1" data-article="<?php echo e(Hashids::encode($feed->feed_id)); ?>">
                    <div class="article-marker"></div>
                    <div class="card">
                        <div class="card-content">
                            <div class="article-user-image">
                                <a href="<?php echo e($feed->user_id==Auth::user()->id ? url(route('profile')) : url(route('accound',encrypt($feed->user_id)))); ?>" class="valign-wrapper">
                                    <?php if(!File::exists($feed->small)): ?>
                                        <img src="<?php echo e(asset('img/default_avatar.png')); ?>" width="50" alt="image-not-found" class="responsive-img circle">&nbsp;
                                    <?php else: ?>
                                        <img src="<?php echo e(asset($feed->small)); ?>" alt="" width="50" class="responsive-img circle">&nbsp;&nbsp;&nbsp;
                                    <?php endif; ?>
                                    <span class="valign"> <?php echo e($feed->user_name); ?></span>
                                </a>
                                <a class='dropdown-button user-search-button-extra-options blue-grey lighten-5 d-inline-block v-align-middle hoverable border-thin' href='#' data-activates='feed-article-n_<?php echo e($key); ?>'><i class="icon-angle-down"></i></a>
                            <?php if($feed->user_id==Auth::user()->id): ?>
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_<?php echo e($key); ?>' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Eliminar <i class="icon-remove red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                            <?php else: ?>
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_<?php echo e($key); ?>' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Reportar \ Bloquear <i class="icon-flag red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <p class="mpadding-tb"><?php if($feed->user_id==Auth::user()->id): ?> I updated my <?php else: ?><b><?php echo e($feed->user_name); ?></b> updated your <?php endif; ?> profile avatar.</p>
                            <div class="no-padding center">
                                <?php if(!File::exists(\Pheaks\Photo::select(['original','large','medium','small'])->where('id','=', $feed->object)->first()->large)): ?>
                                    <img src="<?php echo e(asset('img/photo_unavailable.jpg')); ?>" alt="image-not-found" class="responsive-img valign-wrapper">
                                <?php else: ?>
                                    <a href="<?php echo e(url(route('show-photo'))); ?>" class="show-photo" data-photo-id="<?php echo e(encrypt($feed->object)); ?>">
                                        <img src="<?php echo e(asset(\Pheaks\Photo::select(['original','large','medium','small'])->where('id','=', $feed->object)->first()->large )); ?>" alt="avatar-large" class="responsive-img">
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="#" class="mpadding <?php echo e(\Pheaks\Http\Libraries\Checks::is_liked('photo',$feed->object) ? ' dislike-photo-button blue-text' : ' like-photo-button grey-text'); ?> text-lighten-1" data-photo="<?php echo e(encrypt($feed->object)); ?>">
                                <i class="icon-heart"></i> <span class="like-count"><?php echo e(!empty(\Pheaks\Photo::find($feed->object)->likes) ? \Pheaks\Photo::find($feed->object)->likes()->where('status','1')->count() : '0'); ?></span>
                            </a>
                            <a href="#" class="blue-text text-lighten-1 icon-comment-button" data-form="comment-form-<?php echo e($key); ?>">
                                <i class="icon-comment"></i> <?php echo e(\Pheaks\Photo::find($feed->object)->comments()->count()); ?>

                            </a>
                            <span class="cd-date right">
                                            <small><i class="icon-time"></i> <?php echo e($feed->created_at->diffForHumans()); ?></small>
                                        </span>
                            <div class="col s12" id="comment-form-<?php echo e($key); ?>" style="float: none;display: none;">
                                <?php echo Form::open(['route'=>'commentphoto','class'=>'comment-photo-form']); ?>

                                <div class="row">
                                    <div class="input-field col s12 no-padding">
                                        <textarea id="input-comment-<?php echo e($key); ?>" class="materialize-textarea no-padding" name="comment_photo_text"></textarea>
                                        <label for="input-comment-<?php echo e($key); ?>">Write comment...</label>
                                    </div>
                                    <div class="col s12">
                                        <button type="submit" class="btn btn-block waves-light blue full-width">
                                            <i class="material-icons">send</i>
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="content_elment" value="<?php echo e(encrypt($feed->object)); ?>">
                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div> <!-- cd-timeline-content -->
                </article> <!-- cd-timeline-block -->
                <?php break;
            case 4: ?>
                <article class="my-timeline-block margin-t z-depth-1" data-article="<?php echo e(Hashids::encode($feed->feed_id)); ?>">
                    <div class="article-marker"></div>
                    <div class="card">
                        <div class="card-content">
                            <div class="article-user-image">
                                <a href="<?php echo e($feed->user_id==Auth::user()->id ? url(route('profile')) : url(route('accound',encrypt($feed->user_id)))); ?>" class="valign-wrapper">
                                    <?php if(!File::exists($feed->small)): ?>
                                        <img src="<?php echo e(asset('img/default_avatar.png')); ?>" width="50" alt="image-not-found" class="responsive-img circle">&nbsp;
                                    <?php else: ?>
                                        <img src="<?php echo e(asset($feed->small)); ?>" alt="" width="50" class="responsive-img circle">&nbsp;&nbsp;&nbsp;
                                    <?php endif; ?>
                                    <span class="valign"> <?php echo e($feed->user_name); ?></span>
                                </a>
                                <a class='dropdown-button user-search-button-extra-options blue-grey lighten-5 d-inline-block v-align-middle hoverable border-thin' href='#' data-activates='feed-article-n_<?php echo e($key); ?>'><i class="icon-angle-down"></i></a>
                            <?php if($feed->user_id==Auth::user()->id): ?>
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_<?php echo e($key); ?>' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Eliminar <i class="icon-remove red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                            <?php else: ?>
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_<?php echo e($key); ?>' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Reportar \ Bloquear <i class="icon-flag red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <p class="mpadding-tb"><?php if($feed->user_id==Auth::user()->id): ?> I updated my <?php else: ?><b><?php echo e($feed->user_name); ?></b> updated your <?php endif; ?> profile avatar.</p>
                            <div class="no-padding center">
                                <?php if(!File::exists(\Pheaks\Photo::select(['original','large','medium','small'])->where('id','=', $feed->object)->first()->large)): ?>
                                    <img src="<?php echo e(asset('img/photo_unavailable.jpg')); ?>" alt="image-not-found" class="responsive-img valign-wrapper">
                                <?php else: ?>
                                    <a href="<?php echo e(url(route('show-photo'))); ?>" class="show-photo" data-photo-id="<?php echo e(encrypt($feed->object)); ?>">
                                        <img src="<?php echo e(asset(\Pheaks\Photo::select(['original','large','medium','small'])->where('id','=', $feed->object)->first()->large )); ?>" alt="avatar-large" class="responsive-img">
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="#" class="mpadding <?php echo e(\Pheaks\Http\Libraries\Checks::is_liked('photo',$feed->object) ? ' dislike-photo-button blue-text' : ' like-photo-button grey-text'); ?> text-lighten-1" data-photo="<?php echo e(encrypt($feed->object)); ?>">
                                <i class="icon-heart"></i> <span class="like-count"><?php echo e(!empty(\Pheaks\Photo::find($feed->object)->likes) ? \Pheaks\Photo::find($feed->object)->likes()->where('status','1')->count() : '0'); ?></span>
                            </a>
                            <a href="#" class="blue-text text-lighten-1 icon-comment-button" data-form="comment-form-<?php echo e($key); ?>">
                                <i class="icon-comment"></i> <?php echo e(\Pheaks\Photo::find($feed->object)->comments()->count()); ?>

                            </a>
                            <span class="cd-date right">
                                            <small><i class="icon-time"></i> <?php echo e($feed->created_at->diffForHumans()); ?></small>
                                        </span>
                            <div class="col s12" id="comment-form-<?php echo e($key); ?>" style="float: none;display: none;">
                                <?php echo Form::open(['route'=>'commentphoto','class'=>'comment-photo-form']); ?>

                                <div class="row">
                                    <div class="input-field col s12 no-padding">
                                        <textarea id="input-comment-<?php echo e($key); ?>" class="materialize-textarea no-padding" name="comment_photo_text"></textarea>
                                        <label for="input-comment-<?php echo e($key); ?>">Write comment...</label>
                                    </div>
                                    <div class="col s12">
                                        <button type="submit" class="btn btn-block waves-light blue full-width">
                                            <i class="material-icons">send</i>
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="content_elment" value="<?php echo e(encrypt($feed->object)); ?>">
                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div> <!-- cd-timeline-content -->
                </article> <!-- cd-timeline-block -->
                <?php break;
            default: ?>
                <?php break;
        endswitch; ?>
    <?php endforeach; ?>

<?php endif; ?>