<?php
$settings = App\Models\Utility::settings();
$campaign_type = explode(',',$settings['campaign_type']);
?>
<style>
    .fa-asterisk {
        font-size: xx-small;
        position: absolute;
        padding: 1px;
    }
</style>
<div class="form-group col-md-12">
    <div class="badges">
        <ul class="nav nav-tabs tabActive" style="border-bottom: none">
            <li class="badge rounded p-2 m-1 px-3 bg-primary">
                <a style="color: white;font-size: larger;" data-toggle="tab" href="#barmenu0" class="active">Individual
                    Clients</a>
            </li>
            <li class="badge rounded p-2 m-1 px-3 bg-primary">
                <a style="color: white;    font-size: larger;" data-toggle="tab" href="#barmenu1" class="">Bulk
                    Upload</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="barmenu0" class="tab-pane fade in active show mt-5">
                <?php echo e(Form::open(array('route'=>['importuser'],'method'=>'post','enctype'=>'multipart/form-data','id'=>'imported'))); ?>

                <div class="row">
                    <div class="col-6 need_full">
                        <input type="hidden" name="customerType" value="addForm" />
                        <div class="form-group">
                            <?php echo e(Form::label('name',__('Name'),['class'=>'form-label'])); ?>

                            <span class="text-sm">
                                <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                            </span>
                            <?php echo e(Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Name'),'required'=>'required'))); ?>

                        </div>
                    </div>
                    <div class="col-6 need_full">
                        <div class="form-group">
                            <?php echo e(Form::label('phone',__('Phone'),['class'=>'form-label'])); ?>

                            <span class="text-sm">
                                <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                            </span>
                            <div class="intl-tel-input">
                                <input type="tel" id="phone-input" name="phone" class="phone-input form-control" placeholder="Enter Phone" maxlength="16" required>
                                <input type="hidden" name="countrycode" id="country-code">
                            </div>
                        </div>
                    </div>
                    <div class="col-6 need_full">
                        <div class="form-group">
                            <?php echo e(Form::label('email',__('Email'),['class'=>'form-label'])); ?>

                            <span class="text-sm">
                                <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                            </span>
                            <?php echo e(Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter Email'),'required'=>'required'))); ?>

                        </div>
                    </div>
                    <div class="col-6 need_full">
                        <div class="form-group">
                            <?php echo e(Form::label('address',__('Address'),['class'=>'form-label'])); ?>


                            <?php echo e(Form::text('address',null,array('class'=>'form-control','placeholder'=>__('Enter Address')))); ?>

                        </div>
                    </div>
                    <div class="col-6 need_full">
                        <div class="form-group">
                            <?php echo e(Form::label('organization',__('Organization'),['class'=>'form-label'])); ?>

                            <?php echo e(Form::text('organization',null,array('class'=>'form-control','placeholder'=>__('Enter Organization')))); ?>

                        </div>
                    </div>
                    <div class="col-6 need_full">
                        <div class="form-group">
                            <label for="category">Training and Bind Training</label>
                            <span class="text-sm">
                                <i class="fa fa-asterisk text-danger" aria-hidden="true"></i>
                            </span>
                            <select name="category" id="category" class="form-control" required>
                                <option value="">Training and Bind Training</option>
                                <?php $__currentLoopData = $campaign_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($campaign); ?>" class="form-control"><?php echo e($campaign); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group" style="margin-top: 35px;">
                            <?php echo e(Form::label('name',__('Active'),['class'=>'form-label'])); ?>

                            <input type="checkbox" class="form-check-input" name="is_active" checked>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <?php echo e(Form::submit(__('Save'),array('class'=>'btn btn-primary  '))); ?>

                        </div>
                    </div>
                </div>
                <?php echo e(Form::close()); ?>

            </div>
            <div id="barmenu1" class="tab-pane fade mt-5">
                <?php echo e(Form::open(array('route'=>['importuser'],'method'=>'post','enctype'=>'multipart/form-data'))); ?>

                <div class="row">
                    <input type="hidden" name="customerType" value="uploadFile" />
                    <div class="col-12">
                        <div class="form-group">
                            <label for="category">Select Category</label>
                            <select name="category" id="category" class="form-control" required>
                                <option selected disabled value="">Select Category</option>
                                <?php $__currentLoopData = $campaign_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($campaign); ?>" class="form-control"><?php echo e($campaign); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="col-12">
                        <div class="form-group">
                            <label for="comments">Notes</label>
                           <textarea name="comments" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                    </div> -->
                    <div class="col-12">
                        <div class="form-group">
                            <label for="users">Upload File</label>
                            <input type="file" name="users" id="users" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <?php echo e(Form::submit(__('Save'),array('class'=>'btn btn-primary  '))); ?>

                        </div>
                    </div>
                </div>
                <?php echo e(Form::close()); ?>


                <div class="row">
                    <div class="col-md-12">
                        <span>
                            <h4><b>User's Sample sheet</b></h4>
                        </span>
                        <a href="<?php echo e(asset('/samplecsvuser/usersheet.csv')); ?>" class="btn " title="Download" style="background-color:#77aaaf; color:white" download><i class="fa fa-download"></i></a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<style>
    li:has(> a.active) {
        border-color: #2980b9;
        box-shadow: 0 0 15px rgba(41, 128, 185, 0.8);
    }
</style>
<script>
    //      $(document).ready(function() {  
    //     $("input[type='text'][name= 'name'],input[type='text'][name= 'email'], select[name='category'],input[type='tel'][name='phone']").focusout(function() {  

    //         var input = $(this);
    //         var errorMessage = '';
    //         if (input.attr('name') === 'email' && input.val() !== '') {
    //             var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    //             if (!emailPattern.test(input.val())) {
    //                 errorMessage = 'Invalid email address.';
    //             }
    //         } else if (input.val() == '') {
    //             errorMessage = 'This field is required.';
    //         }

    //         if(errorMessage  != '') {  
    //             input.css('border', 'solid 2px red');
    //         } 
    //         else { 
    //             // If it is not blank. 
    //             input.css('border', 'solid 2px black');
    //         }

    //         // Remove any existing error message
    //         input.next('.validation-error').remove();

    //         // Append the error message if it exists
    //         if(errorMessage != '') {
    //             input.after('<div class="validation-error text-danger" style="padding:2px;">' + errorMessage + '</div>');
    //         }
    //     }); 
    // });
    $(document).ready(function() {
        $("input[type='text'][name= 'name'],input[type='text'][name= 'email'], select[name='category'],input[type='tel'][name='phone']").focusout(function() {
            var input = $(this);
            var errorMessage = '';
            if (input.attr('name') === 'email' && input.val() !== '') {
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(input.val())) {
                    errorMessage = 'Invalid email address.';
                }
            } else if (input.val() == '') {
                errorMessage = 'This field is required.';
            }

            if (errorMessage != '') {
                input.css('border', 'solid 2px red');
            } else {
                // If it is not blank. 
                input.css('border', 'solid 2px black');
            }

            // Remove any existing error message
            input.next('.validation-error').remove();

            // Append the error message if it exists
            if (errorMessage != '') {
                input.after('<div class="validation-error text-danger" style="padding:2px;">' + errorMessage + '</div>');
            }
        });

        $("#imported").validate({
            onfocusout: false,
            rules: {
                'name': {
                    required: true
                },
                'email': {
                    required: true,
                    email: true
                },
                'category': {
                    required: true
                },
                'phone': {
                    required: true
                }
            },
            messages: {
                'name': {
                    required: "Please enter your name"
                },
                'email': {
                    required: "Please enter your email",
                    email: "Please enter a valid email address"
                },
                'category': {
                    required: "Please select a category"
                },
                'phone': {
                    required: "Please enter your phone number"
                }
            },
            errorPlacement: function(error, element) {
                // Display error message inline
                error.insertAfter(element);
            },
            highlight: function(element, errorClass, validClass) {
                // Highlight input fields with error
                $(element).addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                // Unhighlight input fields on valid input
                $(element).removeClass(errorClass).addClass(validClass);
            }
        });
    });
</script><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/customer/uploaduserinfo.blade.php ENDPATH**/ ?>