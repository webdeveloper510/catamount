<?php $__env->startSection('page-title'); ?>
<?php echo e(__('User Edit')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('settings')); ?>"><?php echo e(__('Settings')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('User')); ?></li>
<li class="breadcrumb-item"><?php echo e(__('Edit')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
<!-- <div class="btn-group" role="group">
        <?php if(!empty($previous)): ?>
            <div class="action-btn ms-2">
                <a href="<?php echo e(route('user.edit', $previous)); ?>" class="btn btn-sm btn-primary btn-icon m-1"
                    data-bs-toggle="tooltip" title="<?php echo e(__('Previous')); ?>">
                    <i class="ti ti-chevron-left"></i>
                </a>
            </div>
        <?php else: ?>
            <div class="action-btn ms-2">
                <a href="#" class="btn btn-sm btn-primary btn-icon m-1 disabled" data-bs-toggle="tooltip"
                    title="<?php echo e(__('Previous')); ?>">
                    <i class="ti ti-chevron-left"></i>
                </a>
            </div>
        <?php endif; ?>
        <?php if(!empty($next)): ?>
            <div class="action-btn ms-2">
                <a href="<?php echo e(route('user.edit', $next)); ?>" class="btn btn-sm btn-primary btn-icon m-1"
                    data-bs-toggle="tooltip" title="<?php echo e(__('Next')); ?>">
                    <i class="ti ti-chevron-right"></i>
                </a>
            </div>
        <?php else: ?>
            <div class="action-btn ms-2">
                <a href="#" class="btn btn-sm btn-primary btn-icon m-1 disabled" data-bs-toggle="tooltip"
                    title="<?php echo e(__('Next')); ?>">
                    <i class="ti ti-chevron-right"></i>
                </a>
            </div>
        <?php endif; ?>
    </div> -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
<div class="d-inline-block">
    <h5 class="h4 d-inline-block font-weight-400 mb-0 "><?php echo e(__('Edit User (')); ?> <?php echo e($user->name); ?>

        <?php echo e(')'); ?></h5>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row mt-4">
    <!-- [ sample-page ] start -->
    <div class="col-sm-12">
        <div class="row">
            <div class="col-xl-2">
                <div class="card sticky-top" style="top:30px">
                    <div class="list-group list-group-flush" id="useradd-sidenav">
                        <a href="#useradd-1" class="list-group-item list-group-item-action"><?php echo e(__('Edit User')); ?> <div
                                class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-10">
                <div id="useradd-1" class="card">
                    <?php echo e(Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'PUT','enctype'=>'multipart/form-data'])); ?>

                    <div class="card-header">
                        <h5><?php echo e(__('Overview')); ?></h5>
                        <small class="text-muted"><?php echo e(__('Edit about your user information')); ?></small>
                    </div>

                    <div class="card-body">
                        <!-- <form> -->
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('name', __('Name'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Name'), 'required' => 'required'])); ?>

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
                            <div class="col-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('title', __('Title'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Enter Title'), 'required' => 'required'])); ?>

                                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-title" role="alert">
                                        <strong class="text-danger"><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('email', __('Email'), ['class' => 'form-label'])); ?>

                                    <?php echo e(Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Enter Email'), 'required' => 'required', 'disabled'])); ?>

                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-email" role="alert">
                                        <strong class="text-danger"><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group intl-tel-input">
                                    <?php echo e(Form::label('phone', __('Phone'), ['class' => 'form-label'])); ?>


                                    <div class="intl-tel-input">
                                        <input type="tel" id="phone-input" name="phone" class="phone-input form-control"
                                            placeholder="Enter Phone" maxlength="16" value="">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="countrycode" id="country-code">

                            <div class="col-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('name', __('Gender'), ['class' => 'form-label'])); ?>

                                    <?php echo Form::select('gender', $gender ?? '', $user->gender, ['class' =>
                                    'form-control', 'required' => 'required']); ?>

                                    <?php $__errorArgs = ['gender'];
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
                            <div class="col-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('user_roles', __('Roles'), ['class' => 'form-label'])); ?>

                                    <?php echo Form::select('user_roles', $roles, null, ['class' => 'form-control ',
                                    'required' => 'required']); ?>

                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('name', __('Active'), ['class' => 'form-label'])); ?>

                                    <div>
                                        <input type="checkbox" class="form-check-input" name="is_active"
                                            <?php echo e($user->is_active == 1 ? 'checked' : ''); ?>>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-12 p-0 modaltitle pb-3 mb-3">
                                <h5 style="margin-left: 14px;"><?php echo e(__('Attachments(If Any)')); ?></h5>
                                <!-- <hr class ="mb-4"> -->
                            </div>
                            <div class="col-12">
                                <div class=" form-group">
                                    <?php echo e(Form::label('details',__('Upload Attachments'),['class'=>'form-label'])); ?>

                                    <input type="file" name="details" id="details" class="form-control">
                                </div>
                            </div>

                            <div class="text-end">
                                <?php echo e(Form::submit(__('Save'), ['class' => 'btn-submit btn btn-primary'])); ?>

                            </div>  
                        </div>
                        <!-- </form> -->
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>

                <!-- <?php if(\Auth::user()->type != 'super admin'): ?>
                        <div id="useradd-2" class="card">
                            <?php echo e(Form::open(['route' => ['streamstore', ['user', $user->name, $user->id]], 'method' => 'post', 'enctype' => 'multipart/form-data'])); ?>

                            <div class="card-header">
                                <h5><?php echo e(__('Stream')); ?></h5>
                                <small class="text-muted"><?php echo e(__('Add stream comment')); ?></small>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <?php echo e(Form::label('stream', __('Stream'), ['class' => 'form-label'])); ?>

                                                    <?php echo e(Form::text('stream_comment', null, ['class' => 'form-control', 'placeholder' => __('Enter Stream Comment'), 'required' => 'required'])); ?>

                                                </div>
                                            </div>

                                            <input type="hidden" name="log_type" value="user comment">
                                            <div class="col-12 mb-3 field" data-name="attachments">
                                                <div class="attachment-upload">
                                                    <div class="attachment-button">
                                                        <div class="pull-left">
                                                            <div class="form-group">
                                                            <?php echo e(Form::label('attachment', __('Attachment'), ['class' => 'form-label'])); ?>

                                                            
                                                            <input type="file"name="attachment" class="form-control mb-3" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                                            <img id="blah" width="20%" height="20%"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="attachments"></div>
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <div class="text-end">
                                                    <?php echo e(Form::submit(__('Save'), ['class' => 'btn-submit btn btn-primary'])); ?>

                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>


                            <div class="col-12">
                                <div class="card-header">
                                    <h5><?php echo e(__('Latest comments')); ?></h5>
                                </div>
                                <?php $__currentLoopData = $streams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stream): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $remark = json_decode($stream->remark);
                                    ?>
                                    <?php if($remark->data_id == $user->id): ?>
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-xl-12">
                                                    <ul class="list-group team-msg">
                                                        <li class="list-group-item border-0 d-flex align-items-start mb-2">
                                                            <div class="avatar me-3">
                                                                <?php
                                                                    $profile=\App\Models\Utility::get_file('upload/profile/');
                                                                ?>
                                                                <a href="<?php echo e((!empty($stream->file_upload))? ($profile.$stream->file_upload): asset(url("./assets/images/user/avatar-5.jpg"))); ?>" target="_blank">
                                                                    <img alt="" class="img-user" <?php if(!empty($stream->file_upload)): ?> src="<?php echo e((!empty($stream->file_upload))? ($profile.$stream->file_upload): asset(url("./assets/images/user/avatar-5.jpg"))); ?>" <?php else: ?>  avatar="<?php echo e($remark->user_name); ?>" <?php endif; ?>>
                                                                </a>


                                                            </div>
                                                            <div class="d-block d-sm-flex align-items-center right-side">
                                                                <div
                                                                    class="d-flex align-items-start flex-column justify-content-center mb-3 mb-sm-0">
                                                                    <div class="h6 mb-1"><?php echo e($remark->user_name); ?>

                                                                    </div>
                                                                    <span class="text-sm lh-140 mb-0">
                                                                        posted to <a href="#"><?php echo e($remark->title); ?></a> ,
                                                                        <?php echo e($stream->log_type); ?> <a
                                                                            href="#"><?php echo e($remark->stream_comment); ?></a>
                                                                    </span>
                                                                </div>
                                                                <div class=" ms-2  d-flex align-items-center ">
                                                                    <small
                                                                        class="float-end "><?php echo e($stream->created_at); ?></small>
                                                                </div>
                                                            </div>

                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <?php echo e(Form::close()); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(\Auth::user()->type != 'super admin'): ?>
                        <div id="useradd-3" class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col">
                                        <h5><?php echo e(__('Tasks')); ?></h5>
                                        <small class="text-muted"><?php echo e(__('Assigned tasks of this user')); ?></small>
                                    </div>
                                    <div class="col">
                                        <div class="float-end">
                                            <a href="#" data-size="md" data-url="<?php echo e(route('task.create',['task',0])); ?>"
                                                data-ajax-popup="true" data-bs-toggle="tooltip"
                                                data-title="<?php echo e(__('Create New Task')); ?>" title="<?php echo e(__('Create')); ?>"
                                                class="btn btn-sm btn-primary theme bg-primary btn-icon-only ">
                                                <i class="ti ti-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table datatable" id="datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="sort" data-sort="name">
                                                    <?php echo e(__('Name')); ?></th>
                                                <th scope="col" class="sort" data-sort="budget">
                                                    <?php echo e(__('Assign')); ?></th>
                                                <th scope="col" class="sort" data-sort="status">
                                                    <?php echo e(__('Stage')); ?></th>
                                                <th scope="col" class="sort" data-sort="completion">
                                                    <?php echo e(__('Date Start')); ?></th>
                                                <th scope="col" class="text-end"><?php echo e(__('Action')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <a href="#" data-size="md"
                                                            data-url="<?php echo e(route('task.show', $task->id)); ?>"
                                                            data-ajax-popup="true" data-title="<?php echo e(__('Task Details')); ?>"
                                                            class="action-item text-primary"> <?php echo e($task->name); ?></a>
                                                    </td>
                                                    <td>
                                                        <?php echo e($task->parent); ?>

                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-success p-2 px-3 rounded"><?php echo e(!empty($task->stages) ? $task->stages->name : ''); ?></span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-success p-2 px-3 rounded"><?php echo e(\Auth::user()->dateFormat($task->start_date)); ?></span>
                                                    </td>
                                                    <td class="text-end">

                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Show Task')): ?>
                                                                <div class="action-btn bg-warning ms-2">
                                                                    <a href="#" data-size="md"
                                                                        data-url="<?php echo e(route('task.show', $task->id)); ?>"
                                                                        data-ajax-popup="true" data-bs-toggle="tooltip"
                                                                        data-title="<?php echo e(__('Task Details')); ?>"
                                                                        title="<?php echo e(__('Details')); ?>"
                                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center text-white">
                                                                        <i class="ti ti-eye"></i>
                                                                    </a>
                                                                </div>
                                                            <?php endif; ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Task')): ?>
                                                                <div class="action-btn bg-info ms-2">
                                                                    <a href="<?php echo e(route('task.edit', $task->id)); ?>"
                                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"
                                                                        data-bs-toggle="tooltip" title="<?php echo e(__('Edit')); ?>"
                                                                        data-title="<?php echo e(__('Edit Task')); ?>"><i
                                                                            class="ti ti-edit"></i></a>
                                                                </div>
                                                            <?php endif; ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Task')): ?>
                                                                <div class="action-btn bg-danger ms-2">
                                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['task.destroy', $task->id]]); ?>

                                                                    <a href="#!"
                                                                        class="mx-3 btn btn-sm align-items-center text-white show_confirm"
                                                                        data-bs-toggle="tooltip" title='Delete'>
                                                                        <i class="ti ti-trash"></i>
                                                                    </a>
                                                                    <?php echo Form::close(); ?>

                                                                </div>
                                                            <?php endif; ?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    <?php endif; ?> -->
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>
    <!-- [ Main Content ] end -->
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
<style>
.iti.iti--allow-dropdown.iti--separate-dial-code {
    width: 100%;
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
<script>
$(document).ready(function() {
    var phoneNumber = "<?php echo $user->phone;?>";
    var num = phoneNumber.trim();
    // if (phoneNumber.trim().length < 10) {
    //     alert('Please enter a valid phone number with at least 10 digits.');
    //     return;
    // }
    var lastTenDigits = phoneNumber.substr(-10);
    var formattedPhoneNumber = '(' + lastTenDigits.substr(0, 3) + ') ' + lastTenDigits.substr(3, 3) + '-' +
        lastTenDigits.substr(6);
    $('#phone-input').val(formattedPhoneNumber);
})
$(document).ready(function() {
    var input = document.querySelector("#phone-input");
    var iti = window.intlTelInput(input, {
        separateDialCode: true,
    });

    var indiaCountryCode = iti.getSelectedCountryData().iso2;
    var countryCode = iti.getSelectedCountryData().dialCode;
    $('#country-code').val(countryCode);
    if (indiaCountryCode !== 'us') {
        iti.setCountry('us');
    }
});
</script>

<script>
const isNumericInput = (event) => {
    const key = event.keyCode;
    return ((key >= 48 && key <= 57) || // Allow number line
        (key >= 96 && key <= 105) // Allow number pad
    );
};

const isModifierKey = (event) => {
    const key = event.keyCode;
    return (event.shiftKey === true || key === 35 || key === 36) || // Allow Shift, Home, End
        (key === 8 || key === 9 || key === 13 || key === 46) || // Allow Backspace, Tab, Enter, Delete
        (key > 36 && key < 41) || // Allow left, up, right, down
        (
            // Allow Ctrl/Command + A,C,V,X,Z
            (event.ctrlKey === true || event.metaKey === true) &&
            (key === 65 || key === 67 || key === 86 || key === 88 || key === 90)
        )
};

const enforceFormat = (event) => {
    // Input must be of a valid number format or a modifier key, and not longer than ten digits
    if (!isNumericInput(event) && !isModifierKey(event)) {
        event.preventDefault();
    }
};

const formatToPhone = (event) => {
    if (isModifierKey(event)) {
        return;
    }

    // I am lazy and don't like to type things more than once
    const target = event.target;
    const input = event.target.value.replace(/\D/g, '').substring(0, 10); // First ten digits of input only
    const zip = input.substring(0, 3);
    const middle = input.substring(3, 6);
    const last = input.substring(6, 10);

    if (input.length > 6) {
        target.value = `(${zip}) ${middle} - ${last}`;
    } else if (input.length > 3) {
        target.value = `(${zip}) ${middle}`;
    } else if (input.length > 0) {
        target.value = `(${zip}`;
    }
};

const inputElement = document.getElementById('phone-input');
inputElement.addEventListener('keydown', enforceFormat);
inputElement.addEventListener('keyup', formatToPhone);
</script>
<script>
var scrollSpy = new bootstrap.ScrollSpy(document.body, {
    target: '#useradd-sidenav',
    offset: 300
})
</script>

<script>
$(document).on('change', 'select[name=parent]', function() {

    var parent = $(this).val();
    getparent(parent);
});

function getparent(bid) {
    console.log(bid);
    $.ajax({
        url: '<?php echo e(route("task.getparent")); ?>',
        type: 'POST',
        data: {
            "parent": bid,
            "_token": "<?php echo e(csrf_token()); ?>",
        },
        success: function(data) {
            console.log(data);
            $('#parent_id').empty(); {
                {
                    --$('#parent_id').append('<option value=""><?php echo e(__("Select Parent")); ?></option>');
                    --
                }
            }

            $.each(data, function(key, value) {
                $('#parent_id').append('<option value="' + key + '">' + value + '</option>');
            });
            if (data == '') {
                $('#parent_id').empty();
            }
        }
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/user/edit.blade.php ENDPATH**/ ?>