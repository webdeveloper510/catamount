<?php echo e(Form::open(array('url'=>'role','method'=>'post'))); ?>


<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo e(Form::label('name',__('Name'),['class'=>'col-form-label'])); ?>

            <?php echo e(Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Role Name')))); ?>

            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="invalid-name" role="alert">
                <strong class="text-danger"><?php echo e($message); ?></strong>
            </span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php if(!empty($permissions)): ?>
            <h6><?php echo e(__('Assign Permission to Roles')); ?> </h6>
            <table class="table datatable" id="datatable">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="form-check-input align-middle" name="checkall" id="checkall">
                        </th>
                        <th><?php echo e(__('Module')); ?> </th>
                        <th><?php echo e(__('Permissions')); ?> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $modules=['Role','User','Lead','Meeting','Campaign','Contract','Payment','Report'];
                    $modules=['Role','User','Lead','Training','Invoice','Report','Campaign','Email','Contract'];
                    ?>
                    <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><input type="checkbox" class="form-check-input align-middle ischeck" name="checkall" data-id="<?php echo e(str_replace(' ', '', $module)); ?>"></td>
                        <td><label class="ischeck" data-id="<?php echo e(str_replace(' ', '', $module)); ?>"><?php echo e(ucfirst($module)); ?></label></td>
                        <td>
                            <div class="row ">
                                <?php if(in_array('Manage '.$module,(array) $permissions)): ?>
                                <?php if($key = array_search('Manage '.$module,$permissions)): ?>
                                <div class="col-md-3 custom-control custom-checkbox">
                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'form-check-input custom-control-input isscheck isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                    <?php echo e(Form::label('permission'.$key,'Manage',['class'=>'custom-control-label'])); ?><br>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if(in_array('Create '.$module,(array) $permissions)): ?>
                                <?php if($key = array_search('Create '.$module,$permissions)): ?>
                                <div class="col-md-3 custom-control custom-checkbox">
                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'form-check-input custom-control-input isscheck isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                    <?php echo e(Form::label('permission'.$key,'Create',['class'=>'custom-control-label'])); ?><br>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if(in_array('Edit '.$module,(array) $permissions)): ?>
                                <?php if($key = array_search('Edit '.$module,$permissions)): ?>
                                <div class="col-md-3 custom-control custom-checkbox">
                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'form-check-input custom-control-input isscheck isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                    <?php echo e(Form::label('permission'.$key,'Edit',['class'=>'custom-control-label'])); ?><br>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if(in_array('Delete '.$module,(array) $permissions)): ?>
                                <?php if($key = array_search('Delete '.$module,$permissions)): ?>
                                <div class="col-md-3 custom-control custom-checkbox">
                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'form-check-input custom-control-input isscheck isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                    <?php echo e(Form::label('permission'.$key,'Delete',['class'=>'custom-control-label'])); ?><br>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if(in_array('Show '.$module,(array) $permissions)): ?>
                                <?php if($key = array_search('Show '.$module,$permissions)): ?>
                                <div class="col-md-3 custom-control custom-checkbox">
                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'form-check-input custom-control-input isscheck isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                    <?php echo e(Form::label('permission'.$key,'Show',['class'=>'custom-control-label'])); ?><br>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn btn-secondary btn-light" data-bs-dismiss="modal">
        <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn btn-primary ms-2">
    </div>
</div>
<?php echo e(Form::close()); ?>

<script>
    $(document).ready(function() {
        $("#checkall").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        $(".ischeck").click(function() {
            var ischeck = $(this).data('id');
            $('.isscheck_' + ischeck).prop('checked', this.checked);

        });
    });
</script><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/role/create.blade.php ENDPATH**/ ?>