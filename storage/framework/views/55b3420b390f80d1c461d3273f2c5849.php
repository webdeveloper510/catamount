<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Campaign')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
<?php echo e(__('Campaign')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('Campaign')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php echo e(Form::open(array('route' => 'customer.sendmail','method' =>'post','files' => true))); ?>

<div class="container-field">
    <div id="wrapper1" class="mt-3">
        <div class="page-content-wrapper p0" id="useradd-1" >
            <div class="container-fluid xyz p0">
                <div class="row" >
                    <div class="col-lg-12 ">
                        <div class="row">
                        <div class="col-md-4">
                                <label for="title">Select Recipients</label>
                                <div class="input-group">
                                    <input type='text' name="recipients" class="form-control" id="recipients" readonly placeholder="Please Select Recipient" style="border-right: none;">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-users"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <input type='text' id='autocomplete' name="type" class="form-control" autocomplete="off" required>
                                    <ul id="autocomplete-suggestions" class="list-group"></ul>
                                </div>
                            </div>       
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type='text' name="title" class="form-control" id="abc" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-4">
                                <label for="type">Notify as:</label><br>
                                <div class="form-check form-check-inline createmail">
                                    <input class="form-check-input" type="checkbox" id="email" value="email" name="notify[1][]">
                                    <label class="form-check-label" for="email">Email</label>
                                </div>
                                <div class="form-check form-check-inline createmail">
                                    <input class="form-check-input" type="checkbox" id="text" value="text" name="notify[1][]">
                                    <label class="form-check-label" for="text">Text</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="recepient_names" value="">
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <label>Upload Documents:</label><br>
                                <!-- <input type="file" name="document" id="document" class="form-control" placeholder="Drag and Drop files here"> -->
                                <input type="file" name="document" id="document" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary mt-3" style="float: right;">Continue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="template_html" value="" >
<!-- <div class="template"></div> -->
<div class="modal" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Recipients</h5>
                <button type="button" class="close btn btn-primary" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="#" data-url="<?php echo e(route('campaign.existinguser')); ?>" data-size="lg" data-ajax-popup="true" data-bs-toggle="tooltip" data-title="<?php echo e(__('Edit Recipients')); ?>" title="<?php echo e(__('Select Recipients')); ?>" class="btn btn-primary btn-icon m-1 close width_100" ><?php echo e(__('User Recipients')); ?></a>
                    </div>

                    <div class="col-md-6">
                        <a href="#" data-url="<?php echo e(route('campaign.addeduser')); ?>" data-size="lg" data-ajax-popup="true" data-bs-toggle="tooltip" data-title="<?php echo e(__('Edit Recipients')); ?>" title="<?php echo e(__('Select Recipients')); ?>" class="btn btn-primary btn-icon m-1 close width_100" ><?php echo e(__('List')); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="formatting">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Template</h5>
                <button type="button" class="close btn btn-primary" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6  mt-4">
                        <div class="form-group center-text">
                            <input type="radio" name="format" id="format" class="form-check-input" value="html" style="display: none;">
                            <label for="format" class="form-check-label">
                                <img src="<?php echo e(asset('assets/images/html-formatter.svg')); ?>" alt="Uploaded Image" class="img-thumbnail formatter" id="html_mail" data-bs-toggle="tooltip" title="HTML Mail" style="">
                            </label>
                            <h4 class="mt-2">HTML Mail</h4>
                        </div>

                    </div>
                    <div class="col-6  mt-4">
                        <div class="form-group center-text">
                            <input type="radio" name="format" id="txt" class="form-check-input " value="text" style="display: none;">
                            <label for="txt" class="form-check-label">
                                <img src="<?php echo e(asset('assets/images/text.svg')); ?>" alt="Uploaded Image" class="img-thumbnail formatter" id="text_mail" data-bs-toggle="tooltip" title="Text Mail">
                            </label>
                            <h4 class="mt-2">Text Mail</h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="textformat">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Text Mail</h5>
                <button type="button" class="close btn btn-primary" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        <?php echo e(Form::label('content', __('Message'), ['class' => 'form-control-label text-dark'])); ?>

                        <?php echo e(Form::textarea('content',null, ['class' => 'form-control'])); ?>

                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary close" value="Save" id="message"><?php echo e(__('Save')); ?></button>
                <button type="button" class="btn  btn-light close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="templateoptions" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Template</h5>
                <button type="button" class="close btn btn-primary" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" id="createnewtemplate" class="btn btn-light">Create New Template</button>
                        <button type="button" class="btn btn-light" id="existingtemplates">Use Template</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="edito">
    <div class="modal-dialog" role="document" style="max-width: 75% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Template</h5>
                <button type="button" class="close btn btn-primary close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="editor-container" style="height:500px;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="savedesign"><i class="fa fa-check"></i></button>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="existingedit">
    <div class="modal-dialog" role="document" style="max-width: 75% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Template</h5>
                <button type="button" class="close btn btn-primary close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body new_model">
                <input type="hidden" id="selectedTemplateId" name="selectedTemplateId">
                <?php $__currentLoopData = $campaign; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($cam->template != NULL): ?>
                        <div class="template-container" onclick="selectTemplate('<?php echo e($cam->id); ?>', this)">
                            <input type="radio" class="template-radio visually-hidden" name="template-radio-group" data-template-id="<?php echo e($cam->id); ?>">
                            <div class="template-content" style="pointer-events: none;">
                                <?php echo $cam->template; ?>

                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="selectedtemplate"><i class="fa fa-check"></i></button>
            </div>
        </div>
    </div>
</div>
<?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/summernote/summernote-bs4.css')); ?>">
<style>
    #scrollableDiv {
        max-height: 200px;
        overflow-y: auto;
        padding: 0px;
    }

    div#myModal {
        position: absolute;
    }

    .formatter {
        background: #e3e8ef;
        width: 35%;
        padding: 14px;
        border-radius: 7px;
    }

    #formatter {
        width: 80px;
        height: 80px;
    }

    img#text-icon {
        background: #e3e8ef;
        width: 80px;
        height: 80px;
        padding: 8px;
        border-radius: 7px;
    }

    .selected-image {
        border: 2px solid #3498db !important;
        box-shadow: 0 0 10px rgba(52, 152, 219, 0.5);
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .selected-image:hover {
        border-color: #2980b9;
        box-shadow: 0 0 15px rgba(41, 128, 185, 0.8);
    }

    .selected-template {
        border: 2px solid #3AAEE0;
        /* Add any other styling you want for the selected template */
    }

    .modal-body.new_model {
        display: flex;
    }

    body.theme-4 {
        background: none !important;
    }

    .template-content table {
        background: none !important;
    }

    .u-col.u-col-100 div {
        width: 62% !important;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        function selectTemplate(templateId, templateContainer) {
            // Set border to '2px solid transparent' for all template containers
            document.querySelectorAll('.template-container').forEach(function(container) {
                container.style.border = '2px solid transparent';
                container.classList.remove('selected-container');
            });

            var selectedContainer = templateContainer;

            if (selectedContainer) {
                selectedContainer.style.border = '2px solid #3AAEE0';
                selectedContainer.classList.add('selected-container');

                document.getElementById('selectedTemplateId').value = templateId;
                console.log('Template ID:', templateId);
            } else {
                console.error('Template container not found for ID:', templateId);
            }
        }
        $('.selectedtemplate').click(function(e){
            e.preventDefault();
            $('#existingedit').css('display','none');
        })
    </script>
    <script src="https://editor.unlayer.com/embed.js"></script>
    <script>
        $('#html_mail').click(function() {
            $("#templateoptions").css("display", "block");
            $("#formatting").css("display", "none");
        });
        $('#text_mail').click(function() {
            var descrip = $('textarea[name= "description"]').val();
            $('textarea[name ="content"]').val(descrip);
            $("#textformat").css("display", "block");
            $("#formatting").css("display", "none");

        });
        $('#createnewtemplate').click(function(e){
            $("#edito").css("display", "block");
            $("#formatting").css("display", "none");
        })
        $(document).ready(function() {
            var unlayer = $('#editor-container').unlayer({
                apiKey: '1JIEPtRKTHWUcY5uMLY4TWFs2JHUbYjAcZIyd6ubblfukgU6XfAQkceYXUzI1DpR',
            });
        })
        unlayer.init({
            id: 'editor-container',
            projectId: 119381,
            displayMode: 'email'
        });
        $('.savedesign').click(function(e) {
            e.preventDefault();
            $("#edito").css("display", "none");
            unlayer.exportHtml(function(data) {
                var html = data.html;
                var json = data.design;
                $('input[name="template_html"]').val(html);
           });
        })
        $('#existingtemplates').click(function(e) {
            e.preventDefault();
            $('#existingedit').css('display', 'block');
        })
    </script>
    <script>
        $(document).ready(function() {
            var storedValues = JSON.parse(localStorage.getItem('selectedValues'));
            var recipients = $('input[name="recipients"]').val(storedValues.length + " Recipient Selected")
            $('input[name = "recepient_names"]').val(storedValues);
            localStorage.removeItem('selectedValues');
        });
        $('input[name="format"]').change(function() {
            $('.formatter').removeClass('selected-image');
            if ($(this).is(':checked')) {
                var imageId = $(this).attr('id');
                $('label[for="' + imageId + '"] img').addClass('selected-image');
                // alert(imageId);
            }
            $('input[name="format"]').removeAttr('checked');
            $(this).attr('checked', 'checked');
            $('label[for="' + $(this).attr('id') + '"] img').addClass('selected-image');
        });
        $(".createmail input[type='checkbox']").click(function() {
            $('input[name=content]').val('');
            var $box = $(this);
            if ($box.is(":checked")) {
                var group = "input:checkbox[name='" + $box.attr("name") + "']";
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
            var val = $(this).val();
            var descrip = $('textarea[name= "description"]').val();
            if (val == 'email') {
                $("#formatting").css("display", "block");
            } else if (val == 'text') {
                $("#textformat").css("display", "block");
                $('textarea[name ="content"]').val(descrip);

                $('#message').click(function(e) {
                    e.preventDefault();
                    var text = $('textarea[name ="content"]').val();
                });
            }
        })
    </script>
    <script>
        $('#autocomplete').on("keyup", function() {
            var value = this.value;
            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('auto.campaign_type')); ?>",
                data: {
                    "type": value,
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function(result) {
                    console.log(result);
                    $('#autocomplete-suggestions').empty();
                    $.each(result, function(index, suggestion) {
                        $('#autocomplete-suggestions').append('<li class="list-group-item">' + suggestion + '</li>');
                    });
                    $('#autocomplete-suggestions').on('click', 'li', function() {
                        $('#autocomplete').val($(this).text());
                        $('#autocomplete-suggestions').empty();
                    });
                }
            });
        });
        $(document).ready(function() {
            $("#checkall").click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
            $(".ischeck").click(function() {
                var ischeck = $(this).data('id');
                $('.isscheck_' + ischeck).prop('checked', this.checked);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#recipients").click(function() {
                $("#myModal").css("display", "block");
            });
            $(".close").click(function() {
                $("#myModal").css("display", "none");
                $("#formatting").css("display", "none");
                $("#htmlmail").css("display", "none");
                $("#textformat").css("display", "none");
                $("#edito").css("display", "none");
                $("#templateoptions").css("display", "none");
                $("#existingedit").css("display", "none");   
            })
            $(window).click(function(event) {
                if (event.target.id === "myModal" || event.target.id === "formatting" || event.target.id === "textformat") {
                    $("#myModal").fadeOut("slow");
                    $("#formatting").fadeOut("slow");
                    $("#textformat").fadeOut("slow");
                }
            });
        });
    </script>
    <script src="<?php echo e(asset('css/summernote/summernote-bs4.js')); ?>"></script>
    <script src="<?php echo e(asset('js/plugins/tinymce/tinymce.min.js')); ?>"></script>
    <script>
        if ($(".pc-tinymce-2").length) {
            tinymce.init({
                selector: '.pc-tinymce-2',
                height: "400",
                content_style: 'body { font-family: "Inter", sans-serif; }'
            });
        }
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200,
            });
        });
        $(document).ready(function() {

            // Function to handle checkbox changes in scrollableDiv
            $("#scrollableDiv").on("change", ".pages", function() {
                const checkboxValue = $(this).val();
                const labelText = $(this).parent().text().trim();
                const destinationList = $("#selectedUsers");

                if ($(this).prop("checked")) {
                    // Clone the li element and change the name attribute
                    const clonedLi = $(this).parent().clone();
                    clonedLi.find("input").attr({
                        "name": "selectuser[]",
                        "style": "float: right; display: none;" // Add the style attribute
                    });

                    // Append the cloned li to the second list
                    destinationList.append(clonedLi);
                } else {
                    // Remove the corresponding li from the second list
                    destinationList.find(`input[value="${checkboxValue}"]`).parent().remove();
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\0Work\xampp\htdocs\laravel\ash\catamount\resources\views/customer/index.blade.php ENDPATH**/ ?>