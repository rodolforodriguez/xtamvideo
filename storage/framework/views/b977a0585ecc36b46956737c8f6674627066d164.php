<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.3 -->
<script src="<?php echo e(asset ('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js')); ?>"></script>

<!-- Bootstrap 3.3.2 JS -->
<script src="<?php echo e(asset ('vendor/crudbooster/assets/adminlte/bootstrap/js/bootstrap.min.js')); ?>" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(asset ('vendor/crudbooster/assets/adminlte/dist/js/app.js')); ?>" type="text/javascript"></script>

<!--BOOTSTRAP DATEPICKER-->
<script src="<?php echo e(asset ('vendor/crudbooster/assets/adminlte/plugins/datepicker/bootstrap-datepicker.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset ('vendor/crudbooster/assets/adminlte/plugins/datepicker/datepicker3.css')); ?>">

<!--BOOTSTRAP DATERANGEPICKER-->
<script src="<?php echo e(asset ('vendor/crudbooster/assets/adminlte/plugins/daterangepicker/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset ('vendor/crudbooster/assets/adminlte/plugins/daterangepicker/daterangepicker.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset ('vendor/crudbooster/assets/adminlte/plugins/daterangepicker/daterangepicker-bs3.css')); ?>">

<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="<?php echo e(asset ('vendor/crudbooster/assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.css')); ?>">
<script src="<?php echo e(asset ('vendor/crudbooster/assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.js')); ?>"></script>

<link rel='stylesheet' href='<?php echo e(asset("vendor/crudbooster/assets/lightbox/dist/css/lightbox.min.css")); ?>'/>
<script src="<?php echo e(asset('vendor/crudbooster/assets/lightbox/dist/js/lightbox.min.js')); ?>"></script>

<!--SWEET ALERT-->
<script src="<?php echo e(asset('vendor/crudbooster/assets/sweetalert/dist/sweetalert.min.js')); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendor/crudbooster/assets/sweetalert/dist/sweetalert.css')); ?>">

<!--MONEY FORMAT-->
<script src="<?php echo e(asset('vendor/crudbooster/jquery.price_format.2.0.min.js')); ?>"></script>

<!--DATATABLE-->
<link rel="stylesheet" href="<?php echo e(asset ('vendor/crudbooster/assets/adminlte/plugins/datatables/dataTables.bootstrap.css')); ?>">
<script src="<?php echo e(asset ('vendor/crudbooster/assets/adminlte/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset ('vendor/crudbooster/assets/adminlte/plugins/datatables/dataTables.bootstrap.min.js')); ?>"></script>

<script>
    var ASSET_URL = "<?php echo e(asset('/')); ?>";
    var APP_NAME = "<?php echo e(Session::get('appname')); ?>";
    var ADMIN_PATH = '<?php echo e(url(config("crudbooster.ADMIN_PATH"))); ?>';
    var NOTIFICATION_JSON = "<?php echo e(route('NotificationsControllerGetLatestJson')); ?>";
    var NOTIFICATION_INDEX = "<?php echo e(route('NotificationsControllerGetIndex')); ?>";

    var NOTIFICATION_YOU_HAVE = "<?php echo e(trans('crudbooster.notification_you_have')); ?>";
    var NOTIFICATION_NOTIFICATIONS = "<?php echo e(trans('crudbooster.notification_notification')); ?>";
    var NOTIFICATION_NEW = "<?php echo e(trans('crudbooster.notification_new')); ?>";

    $(function () {
        $('.datatables-simple').DataTable();
    })
</script>
<script src="<?php echo e(asset('vendor/crudbooster/assets/js/main.js').'?r='.time()); ?>"></script>
<script src="<?php echo e(URL::asset('js/app.js')); ?>"></script>


