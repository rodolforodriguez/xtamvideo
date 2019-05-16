<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-<?php echo e(trans('crudbooster.left')); ?> image">
                <img src="<?php echo e(CRUDBooster::myPhoto()); ?>" class="img-circle" alt="<?php echo e(trans('crudbooster.user_image')); ?>" />
            </div>
            <div class="pull-<?php echo e(trans('crudbooster.left')); ?> info">
                <p><?php echo e(CRUDBooster::myName()); ?></p>
            </div>
        </div>
        <div class='main-menu'>
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header"><?php echo e(trans("crudbooster.menu_navigation")); ?></li>
                <?php $__currentLoopData = CRUDBooster::sidebarMenu(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li data-id='<?php echo e($menu->id); ?>' class='<?php echo e((!empty($menu->children))?"treeview":""); ?> <?php echo e((Request::is($menu->url_path."*"))?"active":""); ?>'>
                    <a href='<?php echo e(($menu->is_broken)?"javascript:alert('".trans('crudbooster.controller_route_404')."')":$menu->url); ?>' class='<?php echo e(($menu->color)?"text-".$menu->color:""); ?>'>
                        <i class='<?php echo e($menu->icon); ?> <?php echo e(($menu->color)?"text-".$menu->color:""); ?>'></i> <span><?php echo e($menu->name); ?></span>
                        <?php if(!empty($menu->children)): ?><i class="fa fa-angle-<?php echo e(trans("crudbooster.right")); ?> pull-<?php echo e(trans("crudbooster.right")); ?>"></i><?php endif; ?>
                    </a>
                    <?php if(!empty($menu->children)): ?>
                    <ul class="treeview-menu">
                        <?php $__currentLoopData = $menu->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li data-id='<?php echo e($child->id); ?>' class='<?php echo e((Request::is($child->url_path .= !ends_with(Request::decodedPath(), $child->url_path) ? "/*" : ""))?"active":""); ?>'>
                            <a href='<?php echo e(($child->is_broken)?"javascript:alert('".trans('crudbooster.controller_route_404')."')":$child->url); ?>' class='<?php echo e(($child->color)?"text-".$child->color:""); ?>'>
                                <i class='<?php echo e($child->icon); ?>'></i> <span><?php echo e($child->name); ?></span>
                            </a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php endif; ?>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                <?php if(CRUDBooster::isSuperadmin()): ?>
                <li class="header"><?php echo e(trans('crudbooster.SUPERADMIN')); ?></li>
                <li class='treeview'>
                    <a href='#'><i class='fa fa-key'></i> <span><?php echo e(trans('crudbooster.Privileges_Roles')); ?></span> <i class="fa fa-angle-<?php echo e(trans("crudbooster.right")); ?> pull-<?php echo e(trans("crudbooster.right")); ?>"></i></a>
                    <ul class='treeview-menu'>
                        <li class="<?php echo e((Request::is(config('crudbooster.ADMIN_PATH').'/privileges/add*')) ? 'active' : ''); ?>"><a href='<?php echo e(Route("PrivilegesControllerGetAdd")); ?>'><?php echo e($current_path); ?><i class='fa fa-plus'></i>
                                <span><?php echo e(trans('crudbooster.Add_New_Privilege')); ?></span></a></li>
                        <li class="<?php echo e((Request::is(config('crudbooster.ADMIN_PATH').'/privileges')) ? 'active' : ''); ?>"><a href='<?php echo e(Route("PrivilegesControllerGetIndex")); ?>'><i class='fa fa-bars'></i>
                                <span><?php echo e(trans('crudbooster.List_Privilege')); ?></span></a></li>
                    </ul>
                </li>

                <li class='treeview'>
                    <a href='#'><i class='fa fa-users'></i> <span><?php echo e(trans('crudbooster.Users_Management')); ?></span> <i class="fa fa-angle-<?php echo e(trans("crudbooster.right")); ?> pull-<?php echo e(trans("crudbooster.right")); ?>"></i></a>
                    <ul class='treeview-menu'>
                        <li class="<?php echo e((Request::is(config('crudbooster.ADMIN_PATH').'/users/add*')) ? 'active' : ''); ?>"><a href='<?php echo e(Route("AdminCmsUsersControllerGetAdd")); ?>'><i class='fa fa-plus'></i>
                                <span><?php echo e(trans('crudbooster.add_user')); ?></span></a></li>
                        <li class="<?php echo e((Request::is(config('crudbooster.ADMIN_PATH').'/users')) ? 'active' : ''); ?>"><a href='<?php echo e(Route("AdminCmsUsersControllerGetIndex")); ?>'><i class='fa fa-bars'></i>
                                <span><?php echo e(trans('crudbooster.List_users')); ?></span></a></li>
                    </ul>
                </li>

                <li class="<?php echo e((Request::is(config('crudbooster.ADMIN_PATH').'/menu_management*')) ? 'active' : ''); ?>"><a href='<?php echo e(Route("MenusControllerGetIndex")); ?>'><i class='fa fa-bars'></i>
                        <span><?php echo e(trans('crudbooster.Menu_Management')); ?></span></a></li>
                <li class="treeview">
                    <a href="#"><i class='fa fa-wrench'></i> <span><?php echo e(trans('crudbooster.settings')); ?></span> <i class="fa fa-angle-<?php echo e(trans("crudbooster.right")); ?> pull-<?php echo e(trans("crudbooster.right")); ?>"></i></a>
                    <ul class="treeview-menu">
                        <li class="<?php echo e((Request::is(config('crudbooster.ADMIN_PATH').'/settings/add*')) ? 'active' : ''); ?>"><a href='<?php echo e(route("SettingsControllerGetAdd")); ?>'><i class='fa fa-plus'></i>
                                <span><?php echo e(trans('crudbooster.Add_New_Setting')); ?></span></a></li>
                        <?php
                        $groupSetting = DB::table('cms_settings')->groupby('group_setting')->pluck('group_setting');
                        foreach ($groupSetting as $gs) :
                            ?>
                            <li class="<?= ($gs == Request::get('group')) ? 'active' : '' ?>"><a href='<?php echo e(route("SettingsControllerGetShow")); ?>?group=<?php echo e(urlencode($gs)); ?>&m=0'><i class='fa fa-wrench'></i>
                                    <span><?php echo e($gs); ?></span></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class='treeview'>
                    <a href='#'><i class='fa fa-th'></i> <span><?php echo e(trans('crudbooster.Module_Generator')); ?></span> <i class="fa fa-angle-<?php echo e(trans("crudbooster.right")); ?> pull-<?php echo e(trans("crudbooster.right")); ?>"></i></a>
                    <ul class='treeview-menu'>
                        <li class="<?php echo e((Request::is(config('crudbooster.ADMIN_PATH').'/module_generator/step1')) ? 'active' : ''); ?>"><a href='<?php echo e(Route("ModulsControllerGetStep1")); ?>'><i class='fa fa-plus'></i>
                                <span><?php echo e(trans('crudbooster.Add_New_Module')); ?></span></a></li>
                        <li class="<?php echo e((Request::is(config('crudbooster.ADMIN_PATH').'/module_generator')) ? 'active' : ''); ?>"><a href='<?php echo e(Route("ModulsControllerGetIndex")); ?>'><i class='fa fa-bars'></i>
                                <span><?php echo e(trans('crudbooster.List_Module')); ?></span></a></li>
                    </ul>
                </li>

                <li class='treeview'>
                    <a href='#'><i class='fa fa-dashboard'></i> <span><?php echo e(trans('crudbooster.Statistic_Builder')); ?></span> <i class="fa fa-angle-<?php echo e(trans("crudbooster.right")); ?> pull-<?php echo e(trans("crudbooster.right")); ?>"></i></a>
                    <ul class='treeview-menu'>
                        <li class="<?php echo e((Request::is(config('crudbooster.ADMIN_PATH').'/statistic_builder/add')) ? 'active' : ''); ?>"><a href='<?php echo e(Route("StatisticBuilderControllerGetAdd")); ?>'><i class='fa fa-plus'></i>
                                <span><?php echo e(trans('crudbooster.Add_New_Statistic')); ?></span></a></li>
                        <li class="<?php echo e((Request::is(config('crudbooster.ADMIN_PATH').'/statistic_builder')) ? 'active' : ''); ?>"><a href='<?php echo e(Route("StatisticBuilderControllerGetIndex")); ?>'><i class='fa fa-bars'></i>
                                <span><?php echo e(trans('crudbooster.List_Statistic')); ?></span></a></li>
                    </ul>
                </li>

                <li class='treeview'>
                    <a href='#'><i class='fa fa-fire'></i> <span><?php echo e(trans('crudbooster.API_Generator')); ?></span> <i class="fa fa-angle-<?php echo e(trans("crudbooster.right")); ?> pull-<?php echo e(trans("crudbooster.right")); ?>"></i></a>
                    <ul class='treeview-menu'>
                        <li class="<?php echo e((Request::is(config('crudbooster.ADMIN_PATH').'/api_generator/generator*')) ? 'active' : ''); ?>"><a href='<?php echo e(Route("ApiCustomControllerGetGenerator")); ?>'><i class='fa fa-plus'></i>
                                <span><?php echo e(trans('crudbooster.Add_New_API')); ?></span></a></li>
                        <li class="<?php echo e((Request::is(config('crudbooster.ADMIN_PATH').'/api_generator')) ? 'active' : ''); ?>"><a href='<?php echo e(Route("ApiCustomControllerGetIndex")); ?>'><i class='fa fa-bars'></i>
                                <span><?php echo e(trans('crudbooster.list_API')); ?></span></a></li>
                        <li class="<?php echo e((Request::is(config('crudbooster.ADMIN_PATH').'/api_generator/screet-key*')) ? 'active' : ''); ?>"><a href='<?php echo e(Route("ApiCustomControllerGetScreetKey")); ?>'><i class='fa fa-bars'></i>
                                <span><?php echo e(trans('crudbooster.Generate_Screet_Key')); ?></span></a></li>
                    </ul>
                </li>

                <li class='treeview'>
                    <a href='#'><i class='fa fa-envelope-o'></i> <span><?php echo e(trans('crudbooster.Email_Templates')); ?></span> <i class="fa fa-angle-<?php echo e(trans("crudbooster.right")); ?> pull-<?php echo e(trans("crudbooster.right")); ?>"></i></a>
                    <ul class='treeview-menu'>
                        <li class="<?php echo e((Request::is(config('crudbooster.ADMIN_PATH').'/email_templates/add*')) ? 'active' : ''); ?>"><a href='<?php echo e(Route("EmailTemplatesControllerGetAdd")); ?>'><i class='fa fa-plus'></i>
                                <span><?php echo e(trans('crudbooster.Add_New_Email')); ?></span></a></li>
                        <li class="<?php echo e((Request::is(config('crudbooster.ADMIN_PATH').'/email_templates')) ? 'active' : ''); ?>"><a href='<?php echo e(Route("EmailTemplatesControllerGetIndex")); ?>'><i class='fa fa-bars'></i>
                                <span><?php echo e(trans('crudbooster.List_Email_Template')); ?></span></a></li>
                    </ul>
                </li>

                <li class="<?php echo e((Request::is(config('crudbooster.ADMIN_PATH').'/logs*')) ? 'active' : ''); ?>"><a href='<?php echo e(Route("LogsControllerGetIndex")); ?>'><i class='fa fa-flag'></i> <span><?php echo e(trans('crudbooster.Log_User_Access')); ?></span></a></li>
                <?php endif; ?>

            </ul><!-- /.sidebar-menu -->

        </div>

    </section>
    <!-- /.sidebar -->
</aside>