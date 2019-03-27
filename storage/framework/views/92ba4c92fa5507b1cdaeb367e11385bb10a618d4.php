<?php $__env->startSection('content'); ?>

    <?php $__env->startPush('head'); ?>
        <style type="text/css">
            body.dragging, body.dragging * {
                cursor: move !important;
            }

            .dragged {
                position: absolute;
                opacity: 0.7;
                z-index: 2000;
            }

            .draggable-menu {
                padding: 0 0 0 0;
                margin: 0 0 0 0;
            }

            .draggable-menu li ul {
                margin-top: 6px;
            }

            .draggable-menu li div {
                padding: 5px;
                border: 1px solid #cccccc;
                background: #eeeeee;
                cursor: move;
            }

            .draggable-menu li .is-dashboard {
                background: #fff6e0;
            }

            .draggable-menu li .icon-is-dashboard {
                color: #ffb600;
            }

            .draggable-menu li {
                list-style-type: none;
                margin-bottom: 4px;
                min-height: 35px;
            }

            .draggable-menu li.placeholder {
                position: relative;
                border: 1px dashed #b7042c;
                background: #ffffff;
                /** More li styles **/
            }

            .draggable-menu li.placeholder:before {
                position: absolute;
                /** Define arrowhead **/
            }
        </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('bottom'); ?>
        <script type="text/javascript">
            $(function () {
                function format(icon) {
                    var originalOption = icon.element;
                    var label = $(originalOption).text();
                    var val = $(originalOption).val();
                    if (!val) return label;
                    var $resp = $('<span><i style="margin-top:5px" class="pull-right ' + $(originalOption).val() + '"></i> ' + $(originalOption).data('label') + '</span>');
                    return $resp;
                }

                $('#list-icon').select2({
                    width: "100%",
                    templateResult: format,
                    templateSelection: format
                });
            })
        </script>
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('bottom'); ?>
        <script src='<?php echo e(asset("vendor/crudbooster/assets/jquery-sortable-min.js")); ?>'></script>
        <script type="text/javascript">
            $(function () {
                var id_cms_privileges = '<?php echo e($id_cms_privileges); ?>';
                var sortactive = $(".draggable-menu").sortable({
                    group: '.draggable-menu',
                    delay: 200,
                    isValidTarget: function ($item, container) {
                        var depth = 1, // Start with a depth of one (the element itself)
                            maxDepth = 2,
                            children = $item.find('ul').first().find('li');

                        // Add the amount of parents to the depth
                        depth += container.el.parents('ul').length;

                        // Increment the depth for each time a child
                        while (children.length) {
                            depth++;
                            children = children.find('ul').first().find('li');
                        }

                        return depth <= maxDepth;
                    },
                    onDrop: function ($item, container, _super) {

                        if ($item.parents('ul').hasClass('draggable-menu-active')) {
                            var isActive = 1;
                            var data = $('.draggable-menu-active').sortable("serialize").get();
                            var jsonString = JSON.stringify(data, null, ' ');
                        } else {
                            var isActive = 0;
                            var data = $('.draggable-menu-inactive').sortable("serialize").get();
                            var jsonString = JSON.stringify(data, null, ' ');
                            $('#inactive_text').remove();
                        }

                        $.post("<?php echo e(route('MenusControllerPostSaveMenu')); ?>", {menus: jsonString, isActive: isActive}, function (resp) {
                            $('#menu-saved-info').fadeIn('fast').delay(1000).fadeOut('fast');
                        });

                        _super($item, container);
                    }
                });


            });
        </script>
    <?php $__env->stopPush(); ?>

    <div class='row'>
        <div class="col-sm-5">

            <div class="panel panel-success">
                <div class="panel-heading">
                    <strong>Menu Order (Active)</strong> <span id='menu-saved-info' style="display:none" class='pull-right text-success'><i
                                class='fa fa-check'></i> Menu Saved !</span>
                </div>
                <div class="panel-body clearfix">
                    <ul class='draggable-menu draggable-menu-active'>
                        <?php $__currentLoopData = $menu_active; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $privileges = DB::table('cms_menus_privileges')
                                ->join('cms_privileges','cms_privileges.id','=','cms_menus_privileges.id_cms_privileges')
                                ->where('id_cms_menus',$menu->id)->pluck('cms_privileges.name')->toArray();
                            ?>
                            <li data-id='<?php echo e($menu->id); ?>' data-name='<?php echo e($menu->name); ?>'>
                                <div class='<?php echo e($menu->is_dashboard?"is-dashboard":""); ?>' title="<?php echo e($menu->is_dashboard?'This is setted as Dashboard':''); ?>">
                                    <i class='<?php echo e(($menu->is_dashboard)?"icon-is-dashboard fa fa-dashboard":$menu->icon); ?>'></i> <?php echo e($menu->name); ?> <span
                                            class='pull-right'><a class='fa fa-pencil' title='Edit'
                                                                  href='<?php echo e(route("MenusControllerGetEdit",["id"=>$menu->id])); ?>?return_url=<?php echo e(urlencode(Request::fullUrl())); ?>'></a>&nbsp;&nbsp;<a
                                                title='Delete' class='fa fa-trash'
                                                onclick='<?php echo e(CRUDBooster::deleteConfirm(route("MenusControllerGetDelete",["id"=>$menu->id]))); ?>'
                                                href='javascript:void(0)'></a></span>
                                    <br/><em class="text-muted">
                                        <small><i class="fa fa-users"></i> &nbsp; <?php echo e(implode(', ',$privileges)); ?></small>
                                    </em>
                                </div>
                                <ul>
                                    <?php if($menu->children): ?>
                                        <?php $__currentLoopData = $menu->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $privileges = DB::table('cms_menus_privileges')
                                                ->join('cms_privileges','cms_privileges.id','=','cms_menus_privileges.id_cms_privileges')
                                                ->where('id_cms_menus',$child->id)->pluck('cms_privileges.name')->toArray();
                                            ?>
                                            <li data-id='<?php echo e($child->id); ?>' data-name='<?php echo e($child->name); ?>'>
                                                <div class='<?php echo e($child->is_dashboard?"is-dashboard":""); ?>'
                                                     title="<?php echo e($child->is_dashboard?'This is setted as Dashboard':''); ?>"><i
                                                            class='<?php echo e(($child->is_dashboard)?"icon-is-dashboard fa fa-dashboard":$child->icon); ?>'></i> <?php echo e($child->name); ?>

                                                    <span class='pull-right'><a class='fa fa-pencil' title='Edit'
                                                                                href='<?php echo e(route("MenusControllerGetEdit",["id"=>$child->id])); ?>?return_url=<?php echo e(urlencode(Request::fullUrl())); ?>'></a>&nbsp;&nbsp;<a
                                                                title="Delete" class='fa fa-trash'
                                                                onclick='<?php echo e(CRUDBooster::deleteConfirm(route("MenusControllerGetDelete",["id"=>$child->id]))); ?>'
                                                                href='javascript:void(0)'></a></span>
                                                    <br/><em class="text-muted">
                                                        <small><i class="fa fa-users"></i> &nbsp; <?php echo e(implode(', ',$privileges)); ?></small>
                                                    </em>
                                                </div>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php if(count($menu_active)==0): ?>
                        <div align="center">Active menu is empty, please add new menu</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="panel panel-danger">
                <div class="panel-heading">
                    <strong>Menu Order (Inactive)</strong>
                </div>
                <div class="panel-body clearfix">
                    <ul class='draggable-menu draggable-menu-inactive'>
                        <?php $__currentLoopData = $menu_inactive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li data-id='<?php echo e($menu->id); ?>' data-name='<?php echo e($menu->name); ?>'>
                                <div><i class='<?php echo e($menu->icon); ?>'></i> <?php echo e($menu->name); ?> <span class='pull-right'><a class='fa fa-pencil' title='Edit'
                                                                                                                 href='<?php echo e(route("MenusControllerGetEdit",["id"=>$menu->id])); ?>?return_url=<?php echo e(urlencode(Request::fullUrl())); ?>'></a>&nbsp;&nbsp;<a
                                                title='Delete' class='fa fa-trash'
                                                onclick='<?php echo e(CRUDBooster::deleteConfirm(route("MenusControllerGetDelete",["id"=>$menu->id]))); ?>'
                                                href='javascript:void(0)'></a></span></div>
                                <ul>
                                    <?php if($menu->children): ?>
                                        <?php $__currentLoopData = $menu->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li data-id='<?php echo e($child->id); ?>' data-name='<?php echo e($child->name); ?>'>
                                                <div><i class='<?php echo e($child->icon); ?>'></i> <?php echo e($child->name); ?> <span class='pull-right'><a class='fa fa-pencil'
                                                                                                                                   title='Edit'
                                                                                                                                   href='<?php echo e(route("MenusControllerGetEdit",["id"=>$child->id])); ?>?return_url=<?php echo e(urlencode(Request::fullUrl())); ?>'></a>&nbsp;&nbsp;<a
                                                                title="Delete" class='fa fa-trash'
                                                                onclick='<?php echo e(CRUDBooster::deleteConfirm(route("MenusControllerGetDelete",["id"=>$child->id]))); ?>'
                                                                href='javascript:void(0)'></a></span></div>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php if(count($menu_inactive)==0): ?>
                        <div align="center" id='inactive_text' class='text-muted'>Inactive menu is empty</div>
                    <?php endif; ?>
                </div>
            </div>


        </div>
        <div class="col-sm-7">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Add Menu
                </div>
                <div class="panel-body">
                    <form class='form-horizontal' method='post' id="form" enctype="multipart/form-data" action='<?php echo e(CRUDBooster::mainpath("add-save")); ?>'>
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <input type='hidden' name='return_url' value='<?php echo e(Request::fullUrl()); ?>'/>
                        <?php echo $__env->make("crudbooster::default.form_body", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <p align="right"><input type='submit' class='btn btn-primary' value='Add Menu'/></p>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('crudbooster::admin_template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>