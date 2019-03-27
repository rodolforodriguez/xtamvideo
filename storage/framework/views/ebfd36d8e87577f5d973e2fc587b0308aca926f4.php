<?php if($command=='layout'): ?>
    <div id='<?php echo e($componentID); ?>' class='border-box'>

        <div class="panel panel-default">
            <div class="panel-heading">
                [name]
            </div>
            <div class="panel-body table-responsive no-padding">
                [sql]
            </div>
        </div>

        <div class='action pull-right'>
            <a href='javascript:void(0)' data-componentid='<?php echo e($componentID); ?>' data-name='Small Box' class='btn-edit-component'><i class='fa fa-pencil'></i></a>
            &nbsp;
            <a href='javascript:void(0)' data-componentid='<?php echo e($componentID); ?>' class='btn-delete-component'><i class='fa fa-trash'></i></a>
        </div>
    </div>
<?php elseif($command=='configuration'): ?>
    <form method='post'>
        <input type='hidden' name='_token' value='<?php echo e(csrf_token()); ?>'/>
        <input type='hidden' name='componentid' value='<?php echo e($componentID); ?>'/>
        <div class="form-group">
            <label>Name</label>
            <input class="form-control" required name='config[name]' type='text' value='<?php echo e(@$config->name); ?>'/>
        </div>

        <div class="form-group">
            <label>SQL Query</label>
            <textarea name='config[sql]' rows="5" placeholder="E.g : select column_id,column_name from view_table_name"
                      class='form-control'><?php echo e(@$config->sql); ?></textarea>
            <div class='help-block'>
                Make sure the sql query are correct unless the widget will be broken. Mak sure give the alias name each column. You may use alias [SESSION_NAME]
                to get the session. We strongly recommend that you use a <a href='http://www.w3schools.com/sql/sql_view.asp' target='_blank'>view table</a>
            </div>
        </div>

    </form>
<?php elseif($command=='showFunction'): ?>
    <?php
    if($key == 'sql') {
    try {
        $sessions = Session::all();
        foreach ($sessions as $key => $val) {
            $value = str_replace("[".$key."]", $val, $value);
        }
        $sql = DB::select(DB::raw($value));
    } catch (\Exception $e) {
        die('ERROR');
    }
    ?>

    <?php if($sql): ?>
        <table class='table table-striped'>
            <thead>
            <tr>
                <?php $__currentLoopData = $sql[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e($key); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $sql; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <?php $__currentLoopData = $row; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td><?php echo e($val); ?></td>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <script type="text/javascript">
            $('table.table').DataTable({
                dom: "<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });
        </script>
    <?php endif; ?>
    <?php
    }else {
        echo $value;
    }
    ?>
<?php endif; ?>  

