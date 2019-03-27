<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-<?php echo e(trans('crudbooster.right')); ?> hidden-xs">
        <?php echo e(trans('crudbooster.powered_by')); ?> <?php echo e(Session::get('appname')); ?>

    </div>
    <!-- Default to the left -->
    <strong><?php echo e(trans('crudbooster.copyright')); ?> &copy; <?php echo date('Y') ?>. <?php echo e(trans('crudbooster.all_rights_reserved')); ?> .</strong>
</footer>
