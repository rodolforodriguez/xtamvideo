<?php if($form['datatable']): ?>

    <?php if($form['relationship_table']): ?>
        <?php $__env->startPush('bottom'); ?>
            <script type="text/javascript">
                $(function () {
                    $('#<?php echo e($name); ?>').select2();
                })
            </script>
        <?php $__env->stopPush(); ?>
    <?php else: ?>
        <?php if($form['datatable_ajax'] == true): ?>

            <?php
            $datatable = @$form['datatable'];
            $where = @$form['datatable_where'];
            $format = @$form['datatable_format'];

            $raw = explode(',', $datatable);
            $url = CRUDBooster::mainpath("find-data");

            $table1 = $raw[0];
            $column1 = $raw[1];

            @$table2 = $raw[2];
            @$column2 = $raw[3];

            @$table3 = $raw[4];
            @$column3 = $raw[5];
            ?>

            <?php $__env->startPush('bottom'); ?>
                <script>
                    $(function () {
                        $('#<?php echo e($name); ?>').select2({
                            placeholder: {
                                id: '-1',
                                text: '<?php echo e(trans('crudbooster.text_prefix_option')); ?> <?php echo e($form['label']); ?>'
                            },
                            allowClear: true,
                            ajax: {
                                url: '<?php echo $url; ?>',
                                delay: 250,
                                data: function (params) {
                                    var query = {
                                        q: params.term,
                                        format: "<?php echo e($format); ?>",
                                        table1: "<?php echo e($table1); ?>",
                                        column1: "<?php echo e($column1); ?>",
                                        table2: "<?php echo e($table2); ?>",
                                        column2: "<?php echo e($column2); ?>",
                                        table3: "<?php echo e($table3); ?>",
                                        column3: "<?php echo e($column3); ?>",
                                        where: "<?php echo addslashes($where); ?>"
                                    }
                                    return query;
                                },
                                processResults: function (data) {
                                    return {
                                        results: data.items
                                    };
                                }
                            },
                            escapeMarkup: function (markup) {
                                return markup;
                            },
                            minimumInputLength: 1,
                            <?php if($value): ?>
                            initSelection: function (element, callback) {
                                var id = $(element).val() ? $(element).val() : "<?php echo e($value); ?>";
                                if (id !== '') {
                                    $.ajax('<?php echo e($url); ?>', {
                                        data: {
                                            id: id,
                                            format: "<?php echo e($format); ?>",
                                            table1: "<?php echo e($table1); ?>",
                                            column1: "<?php echo e($column1); ?>",
                                            table2: "<?php echo e($table2); ?>",
                                            column2: "<?php echo e($column2); ?>",
                                            table3: "<?php echo e($table3); ?>",
                                            column3: "<?php echo e($column3); ?>"
                                        },
                                        dataType: "json"
                                    }).done(function (data) {
                                        callback(data.items[0]);
                                        $('#<?php echo $name?>').html("<option value='" + data.items[0].id + "' selected >" + data.items[0].text + "</option>");
                                    });
                                }
                            }

                            <?php endif; ?>
                        });

                    })
                </script>
            <?php $__env->stopPush(); ?>

        <?php else: ?>
            <?php $__env->startPush('bottom'); ?>
                <script type="text/javascript">
                    $(function () {
                        $('#<?php echo e($name); ?>').select2();
                    })
                </script>
            <?php $__env->stopPush(); ?>
        <?php endif; ?>
    <?php endif; ?>
<?php else: ?>

    <?php $__env->startPush('bottom'); ?>
        <script type="text/javascript">
            $(function () {
                $('#<?php echo e($name); ?>').select2();
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
        <select style='width:100%' class='form-control' id="<?php echo e($name); ?>"
                <?php echo e($required); ?> <?php echo e($readonly); ?> <?php echo $placeholder; ?> <?php echo e($disabled); ?> name="<?php echo e($name); ?><?php echo e(($form['relationship_table'])?'[]':''); ?>" <?php echo e(($form['relationship_table'])?'multiple="multiple"':''); ?> >
            <?php if($form['dataenum']): ?>
                <option value=''><?php echo e(trans('crudbooster.text_prefix_option')); ?> <?php echo e($form['label']); ?></option>
                <?php
                $dataenum = $form['dataenum'];
                $dataenum = (is_array($dataenum)) ? $dataenum : explode(";", $dataenum);
                ?>
                <?php $__currentLoopData = $dataenum; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $val = $lab = '';
                    if (strpos($enum, '|') !== FALSE) {
                        $draw = explode("|", $enum);
                        $val = $draw[0];
                        $lab = $draw[1];
                    } else {
                        $val = $lab = $enum;
                    }

                    $select = ($value == $val) ? "selected" : "";
                    ?>
                    <option <?php echo e($select); ?> value='<?php echo e($val); ?>'><?php echo e($lab); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if($form['datatable']): ?>
                <?php if($form['relationship_table']): ?>
                    <?php
                    $select_table = explode(',', $form['datatable'])[0];
                    $select_title = explode(',', $form['datatable'])[1];
                    $select_where = $form['datatable_where'];
                    $pk = CRUDBooster::findPrimaryKey($select_table);

                    $result = DB::table($select_table)->select($pk, $select_title);
                    if ($select_where) {
                        $result->whereraw($select_where);
                    }
                    $result = $result->orderby($select_title, 'asc')->get();


                    $foreignKey = CRUDBooster::getForeignKey($table, $form['relationship_table']);
                    $foreignKey2 = CRUDBooster::getForeignKey($select_table, $form['relationship_table']);

                    $value = DB::table($form['relationship_table'])->where($foreignKey, $id);
                    $value = $value->pluck($foreignKey2)->toArray();

                    foreach ($result as $r) {
                        $option_label = $r->{$select_title};
                        $option_value = $r->id;
                        $selected = (is_array($value) && in_array($r->$pk, $value)) ? "selected" : "";
                        echo "<option $selected value='$option_value'>$option_label</option>";
                    }
                    ?>
                <?php else: ?>
                    <?php if($form['datatable_ajax'] == false): ?>
                        <option value=''><?php echo e(trans('crudbooster.text_prefix_option')); ?> <?php echo e($form['label']); ?></option>
                        <?php
                        $select_table = explode(',', $form['datatable'])[0];
                        $select_title = explode(',', $form['datatable'])[1];
                        $select_where = $form['datatable_where'];
                        $datatable_format = $form['datatable_format'];
                        $select_table_pk = CRUDBooster::findPrimaryKey($select_table);
                        $result = DB::table($select_table)->select($select_table_pk, $select_title);
                        if ($datatable_format) {
                            $result->addSelect(DB::raw("CONCAT(".$datatable_format.") as $select_title"));
                        }
                        if ($select_where) {
                            $result->whereraw($select_where);
                        }
                        if (CRUDBooster::isColumnExists($select_table, 'deleted_at')) {
                            $result->whereNull('deleted_at');
                        }
                        $result = $result->orderby($select_title, 'asc')->get();

                        foreach ($result as $r) {
                            $option_label = $r->{$select_title};
                            $option_value = $r->$select_table_pk;
                            $selected = ($option_value == $value) ? "selected" : "";
                            echo "<option $selected value='$option_value'>$option_label</option>";
                        }
                        ?>
                    <!--end-datatable-ajax-->
                    <?php endif; ?>

                <!--end-relationship-table-->
                <?php endif; ?>

            <!--end-datatable-->
            <?php endif; ?>
        </select>
        <div class="text-danger">
            <?php echo $errors->first($name)?"<i class='fa fa-info-circle'></i> ".$errors->first($name):""; ?>

        </div><!--end-text-danger-->
        <p class='help-block'><?php echo e(@$form['help']); ?></p>

    </div>
</div>
