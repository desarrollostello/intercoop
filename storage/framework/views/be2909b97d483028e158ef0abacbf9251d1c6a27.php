<?php $__env->startSection('content'); ?>
    <!-- Main content -->
    <section class="content col s12 m6">
        <div class="error-page center">
            <div class="error-content">
                <h3 class="black-text">Oops! Page not found.</h3>
                <span class="icon-stack" style="font-size: 8rem;">
                    <i class="icon-link red-text"></i>
                    <i class="icon-ban-circle icon-stack-base black-text"></i>
                </span>
                <p class="black-text">
                    We could not find the page you were looking for.
                    Meanwhile, you may go <?php if(\Auth::check()): ?>
                                        <a href="<?php echo e(url(route('home'))); ?>">to home page
                                    <?php else: ?>
                                        <a href="<?php echo e(url(route('login'))); ?>">to login page
                                    <?php endif; ?> <i class="<?php echo e(\Auth::check() ? 'icon-home' : 'icon-signin'); ?>"></i></a>
                </p>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>