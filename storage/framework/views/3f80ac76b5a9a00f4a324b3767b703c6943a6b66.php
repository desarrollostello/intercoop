<?php $__env->startSection('content'); ?>
	<div class="container row">
        <div id="mdal-for-change-avatar" class="modal">
            <div class="modal-content">
                <h4>Select area to crop</h4>

                <div id="change-avatar-plugin" style="width: 250px;height: 250px;margin: 0 auto;"></div>
            </div>
            <div class="modal-footer">
                <!--<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>-->
            </div>
        </div>
        <div class="col l4 hide-on-med-and-down aside-left-menu no-padding padding-r">
            <div class="collection white">
                <!-- Aside menu left -->
                <?php echo $__env->make('includes.aside-menu-left', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <!-- End aside menu left -->
            </div>
        </div>
        <div class="col s12 l8 no-padding mmargin-t">

			<?php if(Auth::user()->status == '0'): ?>
				<div class="col s12 red border-thin mpadding mmargin-b">
					<?php echo Form::open(['route'=>'sendemailactivation','class'=>'no-margin']); ?>

						<span class="white-text">Your accound is inactive!</span>
						<button class="btn btn-flat lighten-1">
							<span class="white-text">Send email activation</span>
						</button>
					<?php echo Form::close(); ?>

				</div>
				<?php if(!Auth::user()->email): ?>
					<div class="col s12 red border-thin mmargin-b">
						<p class="white-text">Add your email for validate your account.</p>
					</div>
				<?php endif; ?>
			<?php endif; ?>
        	<div class="col s12 white border-thin">
	        	<div class="col s12 l4">
		        	<div class="center">
		        		<div class="col s12 l12 m4 offset-m4">
			        		<img src="<?php echo e(asset(Auth::user()->profile->avatar->medium)); ?>" width="100%" class="circle z-depth-1 mmargin-tb profile-avatar-large">
			        	</div>
			        	<div>
			        		<button class="waves-effect blue waves-light btn d-block edit-profile-avatar" id="edit-profile-avatar">Change <i class="icon-camera"></i></button>
			        	</div>	
		        	</div>
		        </div>
		        <div class="col s12 l8">
					<div class="collection with-header">
		        		<div class="collection-header">
		        			<h5 class="truncate">Personal info</h5>		        			
		    			</div>
		        		<div class="collection-item">Username: <?php echo e(Auth::user()->user_name); ?></div>
		        		<div class="collection-item">Fisrt name: <?php echo e(Auth::user()->first_name); ?></div>
		        		<div class="collection-item">Last name: <?php echo e(Auth::user()->last_name); ?></div>
		        		<div class="collection-item">Email: <?php echo e(Auth::user()->email); ?></div>
		        		<div class="collection-item">Age: <?php echo e(Auth::user()->birthday ? Auth::user()->age : "Not defined"); ?></div>
	        			<a href="<?php echo e(url(route('profile-edit'))); ?>?personal" class="collection-item">Edit <i class="icon-edit"></i></a>
		      		</div>
				</div>
			</div>
	        <div class="col s12 white mmargin-t border-thin">
	        	<h4>Photos</h4>
	        	<div class="slider">
				    <div class="viewer show-photos-space">
				    	<?php if(isset($user_images)): ?>
							<?php foreach($user_images as $key => $image): ?>
								<div id="profile-image-<?php echo e($key); ?>" class="col s12 m4 l3 viewer-image center mmargin-t animated" data-original="<?php echo e($image->original); ?>">
									<div class="profile-image-square" style="overflow:hidden;border-radius: 2.5px 2.5px 0 0;">
										<?php if(\File::exists($image->medium)): ?>
											<a href="<?php echo e(url(route('show-photo'))); ?>" class="show-photo" data-photo-id="<?php echo e(encrypt($image->id)); ?>">
												<!--<img src="<?php echo e($image->small); ?>" class="z-depth-1 responsive-img" alt="" />-->
												<div class="backgroun-avatar-user-image" style="background-image: url('<?php echo e($image->medium); ?>');background-size:cover;background-repeat:no-repeat;background-position:center center;width: 100%;height: 7rem;"></div>
											</a>
										<?php else: ?>
											<a data-photo-id="<?php echo e(encrypt($image->id)); ?>">
												<img src="<?php echo e(asset('img/photo_unavailable.jpg')); ?>" alt="image-not-found" class="z-depth-1 responsive-img">
											</a>
										<?php endif; ?>
									</div>
									<a href="<?php echo e(route('editphoto')); ?>" class="blue mpadding left button-edit-profile-button" data-photo="<?php echo e(\Hashids::encode($image->id)); ?>" style="border-radius: 0 0 0 2.5px;width: 50%">
										<i class="icon-pencil white-text"></i>
									</a>
									<a href="<?php echo e(route('deletephoto')); ?>" class="red mpadding button-delete-profile-photo right" data-photo="<?php echo e(\Hashids::encode($image->id)); ?>" style="border-radius: 0 0 2.5px 0;width: 50%">
										<i class="icon-remove white-text"></i>
									</a>
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							<h3 class="center">Nothing to show</h3>
						<?php endif; ?>
					  <?php /* Sisez image = epic | bigger | normal | mini */ ?>
					</div>
					<div class="button-add-photos col s12 no-padding">
						<div class="col s12 margin-tb">
							<button class="waves-effect btn blue col s12 add-photos">
								<span>Add photos</span> <i class="icon-plus-sign"></i>
							</button>
						</div>
						<!--<div class="col s12 m6 margin-tb">
							<button class="waves-effect btn blue col s12">
								<span>Edit photos</span> <i class="icon-edit"></i>
							</button>
						</div>-->
					</div>
			  	</div>
	        </div>

	        <div class="col s12 white mmargin-t border-thin">	        	
	        	<div class="collection with-header">
	        		<div class="collection-header">
	        			<h5 class="truncate">Basic info</h5>	        			
	    			</div>
	        		<div class="collection-item">
						Signo: <?php echo e(Auth::user()->profile->zodiac_sign ? Auth::user()->profile->zodiac_sign : 'Not defined'); ?>

					</div>
	        		<div class="collection-item">
						Estatura: <?php echo e(Auth::user()->profile->height ? Auth::user()->profile->height : 'Not defined'); ?>

					</div>
	        		<div class="collection-item">
						Sexo: <?php echo e(Auth::user()->sex == "f" ? "Female" : "Male"); ?>

					</div>
	        		<div class="collection-item">
						Complexion: <?php echo e(Auth::user()->profile->complexion ? Auth::user()->profile->complexion : 'Not defined'); ?>

					</div>
	        		<div class="collection-item">
						Estado civil: <?php echo e(Auth::user()->profile->civil_status ? Auth::user()->profile->civil_status : 'Not defined'); ?>

					</div>
	        		<div class="collection-item">
						Hijos: <?php echo e(Auth::user()->profile->children ? Auth::user()->profile->children : 'Not defined'); ?>

					</div>
					<div class="collection-item">
						Language: <?php echo e(Auth::user()->language ? Auth::user()->profile->children : 'en'); ?>

					</div>
	        		<div class="collection-item">
						Educacion: <?php echo e(Auth::user()->profile->education ? Auth::user()->profile->education : 'Not defined'); ?>

					</div>
	        		<div class="collection-item">
						Fuma: <?php echo e(Auth::user()->profile->smoking ? Auth::user()->profile->smoking : 'Not defined'); ?>

					</div>

					<div class="collection-header">
						<h5 class="truncate" style="font-size: 1.5rem;">Location</h5>
					</div>
					<div class="collection-item">Country: <?php echo e(Auth::user()->profile->country ? Auth::user()->profile->country : "Not definded"); ?></div>
					<div class="collection-item">State: <?php echo e(Auth::user()->profile->region ? Auth::user()->profile->region : "Not defined"); ?></div>
					<div class="collection-item">City: <?php echo e(Auth::user()->profile->citie ? Auth::user()->profile->citie : "Not defined"); ?></div>

        			<a href="<?php echo e(url(route('profile-edit'))); ?>?basic" class="collection-item">Edit <i class="icon-edit"></i></a>
	        	</div>
	        </div>
			<div class="col s12 white mmargin-t border-thin">
				<div class="content-header">
					<h4>States</h4>
				</div>
				<?php foreach(\Pheaks\State::whereIn('status',[0,1,2])->where('user_id', Auth::user()->id)->get()->reverse() as $key => $state): ?>
					<article class="my-timeline-block margin-t z-depth-1" data-article="<?php echo e(Hashids::encode($state->id)); ?>">
						<div class="article-marker"></div>
						<div class="card">
							<div class="card-content">
								<div class="article-user-image">
									<span class="valign-wrapper">
										<?php if(!File::exists($state->user()->first()->profile->avatar->small)): ?>
											<img src="<?php echo e(asset('img/default_avatar.png')); ?>" width="50" alt="image-not-found" class="responsive-img circle">&nbsp;
										<?php else: ?>
											<img src="<?php echo e(asset($state->user()->first()->profile->avatar->small)); ?>" alt="" width="50" class="responsive-img circle">&nbsp;&nbsp;&nbsp;
										<?php endif; ?>
										<span class="valign"> <?php echo e($state->user()->first()->user_name); ?></span>
									</span>
									<a class='dropdown-button user-search-button-extra-options blue-grey lighten-5 d-inline-block v-align-middle hoverable border-thin' href='#' data-activates='feed-article-n_<?php echo e($key); ?>'><i class="icon-angle-down"></i></a>

									<!-- Dropdown Structure -->
									<ul id='feed-article-n_<?php echo e($key); ?>' class='dropdown-content user-search-button-extra-options-list'>
										<li>
											<a href="#!" class="blue-text waves-effect">Eliminar <i class="icon-remove red-text lighten-1 right"></i></a>
										</li>
									</ul>
								</div>
								<p class="mpadding-tb">I updated my state.</p>
								<div class="no-padding left">
									<p class="grey-text margin-b"><?php echo e($state->state); ?></p>
								</div>
							</div>
							<div class="card-action">
								<a href="#" class="mpadding <?php echo e(\Pheaks\Http\Libraries\Checks::is_liked('state',$state->id) ? 'dislike-state-button blue-text' : 'like-state-button grey-text'); ?> text-lighten-1" data-state="<?php echo e(encrypt($state->id)); ?>">
									<i class="icon-heart"></i> <span class="like-count"><?php echo e(!empty(\Pheaks\State::find($state->id)->likes) ? \Pheaks\State::find($state->id)->likes()->where('status','1')->count() : '0'); ?></span>
								</a>
								<a href="#" class="blue-text text-lighten-1 icon-comment-button" data-form="comment-form-<?php echo e($key); ?>">
									<i class="icon-comment"></i> <?php echo e(\Pheaks\State::find($state->id)->comments()->count()); ?>

								</a>
								<span class="cd-date right">
									<small><i class="icon-time"></i> <?php echo e($state->created_at->diffForHumans()); ?></small>
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
									<input type="hidden" name="content_elment" value="<?php echo e(encrypt($state->id)); ?>">
									<?php echo Form::close(); ?>

								</div>
								<?php if(!empty(\Pheaks\State::find($state->id)->comments)): ?>
									<div class="col s12 commnets-<?php echo e($key); ?>" style="border-bottom: 1px solid #ececec;border-top: 1px solid #ececec;">
										<?php foreach(\Pheaks\State::find($state->id)->comments()->orderBy('id','desc')->limit(3)->get() as $comment_key => $comment): ?>
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
									<?php if(\Pheaks\State::find($state->id)->comments()->count()>3): ?>
										<div class="col s12 no-padding center">
											<a href="#" class="padding block morefeedcomments" data-type="<?php echo e(Hashids::encode($state->type)); ?>" data-object="<?php echo e(Hashids::encode($state->id)); ?>" data-comments="commnets-<?php echo e($key); ?>">
												<span>Show more comments</span>
											</a>
										</div>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						</div> <!-- cd-timeline-content -->
					</article> <!-- cd-timeline-block -->
				<?php endforeach; ?>
			</div>
        </div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-javascripts'); ?>
	@parent
    <script src="<?php echo e(asset('js/croppic.min.js')); ?>"></script>
	<script>
		$(function(){
		    var croppicOptions = {
                customUploadButtonId:'edit-profile-avatar',
                uploadUrl: '<?php echo e(url(route('upload-avatar'))); ?>',
                cropUrl: '<?php echo e(url(route('crop-avatar'))); ?>',
                uploadData:{
                    "_token": $('#application-token').data('token'),
                },
                cropData:{
                    "_token": $('#application-token').data('token'),
                },
                onBeforeImgUpload: 	function(){
                    $('.spinner-icon-hidden').removeClass('hidden-block');
                },
                onAfterImgUpload: 	function(data){
                    $('.spinner-icon-hidden').addClass('hidden-block');
                    $('#mdal-for-change-avatar').openModal();
                },
                onImgDrag:		function(){ console.log('onImgDrag') },
                onImgZoom:		function(){ console.log('onImgZoom') },
                onBeforeImgCrop: 	function(){ console.log('onBeforeImgCrop') },
                onAfterImgCrop:		function(data){
                    $('.profile-avatar-large').attr('src',data.url);
                    $('.profile-avatar-small').attr('src',data.small);
					$('.show-photos-space').append('<div></div>');
                    $('#mdal-for-change-avatar').closeModal();
                    crop_reset();
                    console.log(data);
                },
                onReset:		function(){
					$('.spinner-icon-hidden').addClass('hidden-block');
				},
                onError:		function(errormsg){
                    var $toas_message = "<div class='red lighten-1'>"+errormsg+"</div>";
                    Materialize.toast($toas_message, 4000);
                },
                imgEyecandy:false,
				rotateControls:false
            };

            var cropperHeader = new Croppic('change-avatar-plugin', croppicOptions);
            var crop_reset = function () {
                cropperHeader.reset();
            }
		});
	</script>
	<?php echo $__env->make('javascripts.content-interactivity', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>