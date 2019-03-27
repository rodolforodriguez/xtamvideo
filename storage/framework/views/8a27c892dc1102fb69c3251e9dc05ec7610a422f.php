<div class='form-group <?php echo e($header_group_class); ?> <?php echo e(($errors->first($name))?"has-error":""); ?>' id='form-group-<?php echo e($name); ?>' style="<?php echo e(@$form['style']); ?>">
    <label class='control-label col-sm-2'><?php echo e($form['label']); ?>

        <?php if($required): ?>
            <span class='text-danger' title='<?php echo trans('crudbooster.this_field_is_required'); ?>'>*</span>
        <?php endif; ?>
    </label>
    <div class="<?php echo e($col_width?:'col-sm-10'); ?>">

        <?php if(!$form['dataenum'] && !$form['datatable'] && !$form['dataquery']): ?>
            <em><?php echo e(trans('crudbooster.there_is_no_option')); ?></em>
        <?php endif; ?>

        <?php if($form['dataenum']!=''): ?>
            <?php
            @$value = explode(";", $value);
            @array_walk($value, 'trim');
            $dataenum = $form['dataenum'];
            $dataenum = (is_array($dataenum)) ? $dataenum : explode(";", $dataenum);
            ?>
            <?php $__currentLoopData = $dataenum; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                if (strpos($d, '|')) {
                    $val = substr($d, 0, strpos($d, '|'));
                    $label = substr($d, strpos($d, '|') + 1);
                } else {
                    $val = $label = $d;
                }
                $checked = ($value && in_array($val, $value)) ? "checked" : "";
                ?>
                <div class=" <?php echo e($disabled); ?>">
                    <label class='radio-inline'>
                        <input type="radio" <?php echo e($disabled); ?> <?php echo e($checked); ?> name="<?php echo e($name); ?>" value="<?php echo e($val); ?>"> <?php echo e($label); ?>

                    </label>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        <?php

        if (@$form['datatable']):
            $datatable_array = explode(",", $form['datatable']);
            $datatable_tab = $datatable_array[0];
            $datatable_field = $datatable_array[1];

            $tables = explode('.', $datatable_tab);
            $selects_data = DB::table($tables[0])->select($tables[0].".id");

            if (CRUDBooster::isColumnExists($tables[0], 'deleted_at')) {
                $selects_data->where('deleted_at', NULL);
            }

            if (@$form['datatable_where']) {
                $selects_data->whereraw($form['datatable_where']);
            }

            if (count($tables)) {
                for ($i = 1; $i <= count($tables) - 1; $i++) {
                    $tab = $tables[$i];
                    $parent_table = $tables[$i - 1];
                    $fk_field = CRUDBooster::getForeignKey($parent_table, $tab);
                    $pk = CRUDBooster::findPrimaryKey($tab) ?: 'id';
                    $selects_data->leftjoin($tab, $tab.'.'.$pk, '=', $fk_field);
                }
            }

            //Because we use join statement, we need to select specified field to avoid ambigous
            $select_field = end($tables).'.'.$datatable_field;
            $select_field_alias = end($tables).'_'.$datatable_field;
            $selects_data->addselect($select_field.' as '.$select_field_alias);
            $selects_data = $selects_data->orderby(end($tables).'.'.$datatable_field, "asc")->get();

            foreach ($selects_data as $d) {
                $val = $d->{$select_field_alias};
                if ($val == '' || ! $d->id) continue;

                $checked = ($value == $d->id) ? "checked" : "";

                echo "
											<div data-val='$val' class='input-radio-wrapper $disabled'>
											  <label class='radio-inline'>
											    <input type='radio' $disabled $checked name='".$name."' value='".$d->id."'> ".$val." 								    
											  </label>
											</div>";
            }

        endif;
        if ($form['dataquery']) {
            $query = DB::select(DB::raw($form['dataquery']));
            if ($query) {
                foreach ($query as $q) {
                    $checked = ($value == $q->value) ? "checked" : "";
                    echo "<div data-val='$val' class=' $disabled'>
																<label class='radio-inline'>
																	<input type='radio' $disabled $checked name='".$name."' value='$q->value'> ".$q->label."								    
																</label>
																</div>";
                }
            }
        }
        ?>
        <div class="text-danger"><?php echo $errors->first($name)?"<i class='fa fa-info-circle'></i> ".$errors->first($name):""; ?></div>
        <p class='help-block'><?php echo e(@$form['help']); ?></p>
    </div>
</div>