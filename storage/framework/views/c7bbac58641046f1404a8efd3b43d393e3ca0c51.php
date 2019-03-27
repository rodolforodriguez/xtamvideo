<div class='form-group <?php echo e($header_group_class); ?> <?php echo e(($errors->first($name))?"has-error":""); ?>' id='form-group-<?php echo e($name); ?>' style="<?php echo e(@$form['style']); ?>">
    <label class='control-label col-sm-2'><?php echo e($form['label']); ?>

        <?php if($required): ?>
            <span class='text-danger' title='<?php echo trans('crudbooster.this_field_is_required'); ?>'>*</span>
        <?php endif; ?>
    </label>

    <div class="<?php echo e($col_width?:'col-sm-10'); ?>">
        <?php echo $form['html']; ?>


        <div class="text-danger"><?php echo $errors->first($name)?"<i class='fa fa-info-circle'></i> ".$errors->first($name):""; ?></div>
        <p class='help-block'><?php echo e(@$form['help']); ?></p>
    </div>
</div>