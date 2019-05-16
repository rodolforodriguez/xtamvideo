<?php
$xtamPerName = DB::table('xtam_profile_inst')
    ->select('Profile_Description')
    ->where('profile_StatusChek', '=', '1')
    ->get();
$name = substr($xtamPerName, 25, -3);

$Login = DB::table('xtam_profile_inst')
    ->select('Profile_StatusChek')
    ->where('Profile_StatusChek', '=', '1')
    ->get();
$tamaño = sizeof($Login);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php echo e(strip_tags($page_title)); ?></title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
    <meta name='generator' content='CRUDBooster 5.4.6'/>
    <meta name='robots' content='noindex,nofollow'/>
    <link rel="shortcut icon"
          href="<?php echo e(CRUDBooster::getSetting('favicon')?asset(CRUDBooster::getSetting('favicon')):asset('vendor/crudbooster/assets/logo_crudbooster.png')); ?>">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?php echo e(asset("vendor/crudbooster/assets/adminlte/bootstrap/css/bootstrap.min.css")); ?>" rel="stylesheet" type="text/css"/>
    <!-- Font Awesome Icons -->
    <link href="<?php echo e(asset("vendor/crudbooster/assets/adminlte/font-awesome/css")); ?>/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <!-- Ionicons -->
    <link href="<?php echo e(asset("vendor/crudbooster/ionic/css/ionicons.min.css")); ?>" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="<?php echo e(asset("vendor/crudbooster/assets/adminlte/dist/css/AdminLTE.min.css")); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(asset("vendor/crudbooster/assets/adminlte/dist/css/skins/_all-skins.min.css")); ?>" rel="stylesheet" type="text/css"/>

    <!-- support rtl-->
    <?php if(in_array(App::getLocale(), ['ar', 'fa'])): ?>
        <link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">
        <link href="<?php echo e(asset("vendor/crudbooster/assets/rtl.css")); ?>" rel="stylesheet" type="text/css"/>
    <?php endif; ?>

    <link rel='stylesheet' href='<?php echo e(asset("vendor/crudbooster/assets/css/main.css").'?r='.time()); ?>'/>

    <!-- load css -->
    <style type="text/css">
        <?php if($style_css): ?>
            <?php echo $style_css; ?>


        <?php endif; ?>
    </style>
    <?php if($load_css): ?>
        <?php $__currentLoopData = $load_css; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $css): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <link href="<?php echo e($css); ?>" rel="stylesheet" type="text/css"/>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <style type="text/css">
        .dropdown-menu-action {
            left: -130%;
        }

        .btn-group-action .btn-action {
            cursor: default
        }

        #box-header-module {
            box-shadow: 10px 10px 10px #dddddd;
        }

        .sub-module-tab li {
            background: #F9F9F9;
            cursor: pointer;
        }

        .sub-module-tab li.active {
            background: #ffffff;
            box-shadow: 0px -5px 10px #cccccc
        }

        .nav-tabs > li.active > a,
		.nav-tabs > li.active > a:focus,
		.nav-tabs > li.active > a:hover {
            border: none;
        }

        .nav-tabs > li > a {
            border: none;
        }

        .breadcrumb {
            margin: 0 0 0 0;
            padding: 0 0 0 0;
        }

        .form-group > label:first-child {
            display: block
        }
    </style>

    <?php echo $__env->yieldPushContent('head'); ?>
</head>
<?php
if ($tamaño === 0) {
    ?>
    <body class="<?php echo (Session::get('theme_color'))?:'skin-red'; echo ' sidebar-collapse'; echo config('crudbooster.ADMIN_LAYOUT'); ?> <?php echo e(($sidebar_mode)?:''); ?>">
    <?php
} else {
    ?>
        <body class="<?php echo (Session::get('theme_color'))?:'skin-red'; echo ' '; echo config('crudbooster.ADMIN_LAYOUT'); ?> <?php echo e(($sidebar_mode)?:''); ?>">
        <?php
    }
    ?>  
<div id='app' class="wrapper">

    <!-- Header -->
<?php echo $__env->make('crudbooster::header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<!-- Sidebar -->
<?php echo $__env->make('crudbooster::sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <section class="content-header">
            <?php
            $module = CRUDBooster::getCurrentModule();
            ?>
            <?php if($module): ?>
                <h1>
                    <i class='<?php echo e($module->icon); ?>'></i> <?php echo e(($page_title)?:$module->name); ?> &nbsp;&nbsp;

                    <!--START BUTTON -->

                    <?php if(CRUDBooster::getCurrentMethod() == 'getIndex'): ?>
                        <?php if($button_show): ?>
                            <a href="<?php echo e(CRUDBooster::mainpath().'?'.http_build_query(Request::all())); ?>" id='btn_show_data' class="btn btn-sm btn-primary"
                               title="<?php echo e(trans('crudbooster.action_show_data')); ?>">
                                <i class="fa fa-table"></i> <?php echo e(trans('crudbooster.action_show_data')); ?>

                            </a>
                        <?php endif; ?>

                        <?php if($button_add && CRUDBooster::isCreate()): ?>
                            <a href="<?php echo e(CRUDBooster::mainpath('add').'?return_url='.urlencode(Request::fullUrl()).'&parent_id='.g('parent_id').'&parent_field='.$parent_field); ?>"
                               id='btn_add_new_data' class="btn btn-sm btn-success" title="<?php echo e(trans('crudbooster.action_add_data')); ?>">
                                <i class="fa fa-plus-circle"></i> <?php echo e(trans('crudbooster.action_add_data')); ?>

                            </a>
                        <?php endif; ?>
                    <?php endif; ?>


                    <?php if($button_export && CRUDBooster::getCurrentMethod() == 'getIndex'): ?>
                        <a href="javascript:void(0)" id='btn_export_data' data-url-parameter='<?php echo e($build_query); ?>' title='Export Data'
                           class="btn btn-sm btn-primary btn-export-data">
                            <i class="fa fa-upload"></i> <?php echo e(trans("crudbooster.button_export")); ?>

                        </a>
                    <?php endif; ?>

                    <?php if($button_import && CRUDBooster::getCurrentMethod() == 'getIndex'): ?>
                        <a href="<?php echo e(CRUDBooster::mainpath('import-data')); ?>" id='btn_import_data' data-url-parameter='<?php echo e($build_query); ?>' title='Import Data'
                           class="btn btn-sm btn-primary btn-import-data">
                            <i class="fa fa-download"></i> <?php echo e(trans("crudbooster.button_import")); ?>

                        </a>
                    <?php endif; ?>

                <!--ADD ACTIon-->
                    <?php if(!empty($index_button)): ?>

                        <?php $__currentLoopData = $index_button; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ib): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href='<?php echo e($ib["url"]); ?>' id='<?php echo e(str_slug($ib["label"])); ?>' class='btn <?php echo e(($ib['color'])?'btn-'.$ib['color']:'btn-primary'); ?> btn-sm'
                               <?php if($ib['onClick']): ?> onClick='return <?php echo e($ib["onClick"]); ?>' <?php endif; ?>
                               <?php if($ib['onMouseOver']): ?> onMouseOver='return <?php echo e($ib["onMouseOver"]); ?>' <?php endif; ?>
                               <?php if($ib['onMouseOut']): ?> onMouseOut='return <?php echo e($ib["onMouseOut"]); ?>' <?php endif; ?>
                               <?php if($ib['onKeyDown']): ?> onKeyDown='return <?php echo e($ib["onKeyDown"]); ?>' <?php endif; ?>
                               <?php if($ib['onLoad']): ?> onLoad='return <?php echo e($ib["onLoad"]); ?>' <?php endif; ?>
                            >
                                <i class='<?php echo e($ib["icon"]); ?>'></i> <?php echo e($ib["label"]); ?>

                            </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <!-- END BUTTON -->
                </h1>


                <ol class="breadcrumb">
                    <li><a href="<?php echo e(CRUDBooster::adminPath()); ?>"><i class="fa fa-dashboard"></i> <?php echo e(trans('crudbooster.home')); ?></a></li>
                    <li class="active"><?php echo e($module->name); ?></li>
                </ol>
            <?php else: ?>
            <h1><?php echo e($name); ?></h1>
            <?php endif; ?>
        </section>


        <!-- Main content -->
        <section id='content_section' class="content">

            <?php if(@$alerts): ?>
                <?php $__currentLoopData = @$alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class='callout callout-<?php echo e($alert["type"]); ?>'>
                        <?php echo $alert['message']; ?>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>


            <?php if(Session::get('message')!=''): ?>
                <div class='alert alert-<?php echo e(Session::get("message_type")); ?>'>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> <?php echo e(trans("crudbooster.alert_".Session::get("message_type"))); ?></h4>
                    <?php echo Session::get('message'); ?>

                </div>
            <?php endif; ?>



        <!-- Your Page Content Here -->
            <?php echo $__env->yieldContent('content'); ?>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    <?php echo $__env->make('crudbooster::footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</div><!-- ./wrapper -->


<?php echo $__env->make('crudbooster::admin_template_plugins', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<!-- load js -->
<?php if($load_js): ?>
    <?php $__currentLoopData = $load_js; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $js): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script src="<?php echo e($js); ?>"></script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<script type="text/javascript">
    var site_url = "<?php echo e(url('/')); ?>";
    <?php if($script_js): ?>
        <?php echo $script_js; ?>	 
    <?php endif; ?>
</script>

<?php echo $__env->yieldPushContent('bottom'); ?>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->
</body>
</html>

	   