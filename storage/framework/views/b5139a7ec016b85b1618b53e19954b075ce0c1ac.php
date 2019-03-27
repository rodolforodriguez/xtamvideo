<?php $default = ! empty($form['default']) ? $form['default'] : trans('crudbooster.text_prefix_option')." ".$form['label'];?>
<?php if($form['parent_select']): ?>
    <?php
    $parent_select = (count(explode(",", $form['parent_select'])) > 1) ? explode(",", $form['parent_select']) : $form['parent_select'];
    $parent = is_array($parent_select) ? $parent_select[0] : $parent_select;
    $add_field = is_array($parent_select) ? $parent_select[1] : '';
    ?>
    <?php $__env->startPush('bottom'); ?>
        <script type="text/javascript">
            $(function () {
                $('#<?php echo e($parent); ?>, input:radio[name=<?php echo e($parent); ?>]').change(function () {
                    var $current = $("#<?php echo e($form['name']); ?>");
                    var parent_id = $(this).val();
                    var fk_name = "<?php echo e($parent); ?>";
                    var fk_value = $(this).val();
                    var datatable = "<?php echo e($form['datatable']); ?>".split(',');
                            <?php if(!empty($add_field)): ?>
                    var add_field = ($("#<?php echo e($add_field); ?>").val()) ? $("#<?php echo e($add_field); ?>").val() : "";
                            <?php endif; ?>
                    var datatableWhere = "<?php echo e($form['datatable_where']); ?>";
                    <?php if(!empty($add_field)): ?>
                    if (datatableWhere) {
                        if (add_field) {
                            datatableWhere = datatableWhere + " and <?php echo e($add_field); ?> = " + add_field;
                        }
                    } else {
                        if (add_field) {
                            datatableWhere = "<?php echo e($add_field); ?> = " + add_field;
                        }
                    }
                            <?php endif; ?>
                    var table = datatable[0].trim('');
                    var label = datatable[1].trim('');
                    var value = "<?php echo e($value); ?>";

                    if (fk_value != '') {
                        $current.html("<option value=''><?php echo e(trans('crudbooster.text_loading')); ?> <?php echo e($form['label']); ?>");
                        $.get("<?php echo e(CRUDBooster::mainpath('data-table')); ?>?table=" + table + "&label=" + label + "&fk_name=" + fk_name + "&fk_value=" + fk_value + "&datatable_where=" + encodeURI(datatableWhere), function (response) {
                            if (response) {
                                $current.html("<option value=''><?php echo e($default); ?>");
                                $.each(response, function (i, obj) {
                                    var selected = (value && value == obj.select_value) ? "selected" : "";
                                    $("<option " + selected + " value='" + obj.select_value + "'>" + obj.select_label + "</option>").appendTo("#<?php echo e($form['name']); ?>");
                                })
                                $current.trigger('change');
                            }
                        });
                    } else {
                        $current.html("<option value=''><?php echo e($default); ?>");
                    }
                })

                $('#<?php echo e($parent); ?>').trigger('change');
                $("input[name='<?php echo e($parent); ?>']:checked").trigger("change");
                $("#<?php echo e($form['name']); ?>").trigger('change');
            })
        </script>
    <?php $__env->stopPush(); ?>

<?php endif; ?>
<div class='form-group <?php echo e($header_group_class); ?> <?php echo e(($errors->first($name))?"has-error":""); ?>' id='form-group-<?php echo e($name); ?>' style="<?php echo e(@$form['style']); ?>">
    <label class='control-label col-sm-2'><?php echo e($form['label']); ?>

        <?php if($required): ?>
            <span class='text-danger' title='<?php echo trans('crudbooster.this_field_is_required'); ?>'>*</span>
        <?php endif; ?>
    </label>

    <div class="<?php echo e($col_width?:'col-sm-10'); ?>">
        <select class='form-control' id="<?php echo e($name); ?>" data-value='<?php echo e($value); ?>' <?php echo e($required); ?> <?php echo $placeholder; ?> <?php echo e($readonly); ?> <?php echo e($disabled); ?> name="<?php echo e($name); ?>">
            <option value=''><?php echo e($default); ?></option>
            <?php
            if (! $form['parent_select']) {
                if (@$form['dataquery']):

                    $query = DB::select(DB::raw($form['dataquery']));
                    if ($query) {
                        foreach ($query as $q) {
                            $selected = ($value == $q->value) ? "selected" : "";
                            echo "<option $selected value='$q->value'>$q->label</option>";
                        }
                    }

                endif;

                if (@$form['dataenum']):
                    $dataenum = $form['dataenum'];
                    $dataenum = (is_array($dataenum)) ? $dataenum : explode(";", $dataenum);

                    foreach ($dataenum as $d) {

                        $val = $lab = '';
                        if (strpos($d, '|') !== FALSE) {
                            $draw = explode("|", $d);
                            $val = $draw[0];
                            $lab = $draw[1];
                        } else {
                            $val = $lab = $d;
                        }

                        $select = ($value == $val) ? "selected" : "";

                        echo "<option $select value='$val'>$lab</option>";
                    }
                endif;

                if (@$form['datatable']):
                    $raw = explode(",", $form['datatable']);
                    $format = $form['datatable_format'];
                    $table1 = $raw[0];
                    $column1 = $raw[1];

                    @$table2 = $raw[2];
                    @$column2 = $raw[3];

                    @$table3 = $raw[4];
                    @$column3 = $raw[5];

                    $selects_data = DB::table($table1)->select($table1.".id");

                    if (\Schema::hasColumn($table1, 'deleted_at')) {
                        $selects_data->where($table1.'.deleted_at', NULL);
                    }

                    if (@$form['datatable_where']) {
                        $selects_data->whereraw($form['datatable_where']);
                    }

                    if ($table1 && $column1) {
                        $orderby_table = $table1;
                        $orderby_column = $column1;
                    }

                    if ($table2 && $column2) {
                        $selects_data->join($table2, $table2.'.id', '=', $table1.'.'.$column1);
                        $orderby_table = $table2;
                        $orderby_column = $column2;
                    }

                    if ($table3 && $column3) {
                        $selects_data->join($table3, $table3.'.id', '=', $table2.'.'.$column2);
                        $orderby_table = $table3;
                        $orderby_column = $column3;
                    }

                    if ($format) {
                        $format = str_replace('&#039;', "'", $format);
                        $selects_data->addselect(DB::raw("CONCAT($format) as label"));
                        $selects_data = $selects_data->orderby(DB::raw("CONCAT($format)"), "asc")->get();
                    } else {
                        $selects_data->addselect($orderby_table.'.'.$orderby_column.' as label');
                        $selects_data = $selects_data->orderby($orderby_table.'.'.$orderby_column, "asc")->get();
                    }

                    foreach ($selects_data as $d) {

                        $val = $d->id;
                        $select = ($value == $val) ? "selected" : "";

                        echo "<option $select value='$val'>".$d->label."</option>";
                    }
                endif;
            } //end if not parent select
            ?>
        </select>
        <div class="text-danger"><?php echo $errors->first($name)?"<i class='fa fa-info-circle'></i> ".$errors->first($name):""; ?></div>
        <p class='help-block'><?php echo e(@$form['help']); ?></p>
    </div>
</div>