<?php $__env->startSection('content'); ?>
	<div class="container row">
		<div class="col l4 hide-on-med-and-down aside-left-menu no-padding padding-r">
            <div class="collection white">
                <!-- Aside menu left -->
                <?php echo $__env->make('includes.aside-menu-left', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <!-- End aside menu left -->
            </div>
        </div>
        <div class="col l8 no-padding mmargin-t">
        	<div class="col s12 white border-thin">
        		<div class="col s12 no-padding">
					<h5 class="left">Visitors</h5>
					<!--<div class="right mmargin-t">
					  	<select class="browser-default">
					    	<option value="1">Visit you</option>
					    	<option value="2">You visited</option>
					  	</select>
					</div>-->
				</div>
        		<div class="col s12 no-padding" style="min-height: 20rem">
					<?php if($likes->count()>0): ?>
						<div class="collection">
						<?php foreach($likes as $key => $user): ?>
							<?php if($user->from->id==Auth::user()->id): ?>
								<a href="<?php echo e(route('accound', encrypt($user->to()->first()->id))); ?>" class="collection-item blue-text text-lighten-1 avatar valign-wrapper" style="min-height: 4.5rem;">
									<div class="col s10 valign">
										<?php if(File::exists($user->to()->first()->profile->avatar->small)): ?>
											<img src="<?php echo e(asset($user->to()->first()->profile->avatar->small)); ?>" alt="" class="responsive-img circle">
										<?php else: ?>
											<img src="<?php echo e(asset('img/default_avatar.png')); ?>" alt="image-not-found" class="responsive-img circle">&nbsp;
										<?php endif; ?>
										<span class="title">
											<p class="no-margin"><?php echo e($user->to()->first()->user_name); ?></p>
											<p class="no-margin"><small><?php echo e($user->updated_at->diffForHumans()); ?></small></p>
										</span>
									</div>
									<div class="col s2 valign">
										<span class="badge">He likes you</span>
									</div>
								</a>
							<?php else: ?>
								<a href="<?php echo e(route('accound', encrypt($user->from()->first()->id))); ?>" class="collection-item blue-text text-lighten-1 avatar valign-wrapper" style="min-height: 4.5rem;">
									<div class="col s10 valign">
										<?php if(File::exists($user->from()->first()->profile->avatar->small)): ?>
											<img src="<?php echo e(asset($user->from()->first()->profile->avatar->small)); ?>" alt="" class="responsive-img circle">
										<?php else: ?>
											<img src="<?php echo e(asset('img/default_avatar.png')); ?>" alt="image-not-found" class="responsive-img circle">&nbsp;
										<?php endif; ?>
										<span class="title">
										<p class="no-margin"><?php echo e($user->from()->first()->user_name); ?></p>
										<p class="no-margin"><small><?php echo e($user->updated_at->diffForHumans()); ?></small></p>
									</span>
									</div>
									<div class="col s2 valign">
										<span class="badge">you like</span>
									</div>
								</a>
							<?php endif; ?>
						<?php endforeach; ?>
						</div>
					<?php else: ?>
						<h2 class="padding-lr center">Nothing to show</h2>
						<div class="center padding-b">
							<a href="<?php echo e(url(route('search'))); ?>"class="btn waves-effect waves-block blue">Find people</a>
						</div>
					<?php endif; ?>
        		</div>
        	</div>
    	</div>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>