@if(\Auth::user()->type == 'super admin')
{{Form::open(array('url'=>'user','method'=>'post','enctype'=>'multipart/form-data'))}}
<div class="form-group">
    {{Form::label('name',__('User Name'),['class'=>'form-label']) }}
    {{Form::text('username',null,array('class'=>'form-control','placeholder'=>__('Enter User Name'),'required'=>'required'))}}
</div>
<div class="form-group">
    {{Form::label('name',__('Name'),array('class'=>'form-label')) }}
    {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter User Name'),'required'=>'required'))}}
</div>
<div class="form-group">
    {{Form::label('email',__('Email'),['class'=>'form-label'])}}
    {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email'),'required'=>'required'))}}
</div>
<div class="form-group">
    {{Form::label('password',__('Password'),['class'=>'form-label'])}}
    {{Form::password('password',array('class'=>'form-control','placeholder'=>__('Enter User Password'),'required'=>'required','minlength'=>"6"))}}
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">Close</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary '))}}
</div>

{{Form::close()}}
@else
{{Form::open(array('url'=>'user','method'=>'post','enctype'=>'multipart/form-data'))}}
<div class="row">
    <div class="col-6 need_full">
        <div class="form-group">
            {{Form::label('name',__('Name'),['class'=>'form-label']) }}
            {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Name'),'required'=>'required'))}}
        </div>
    </div>
    <div class="col-6 need_full">
        <div class="form-group">
            {{Form::label('name',__('Title'),['class'=>'form-label']) }}
            {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Title'),'required'=>'required'))}}
        </div>
    </div>

    <div class="col-6 need_full">
        <div class="form-group">
            {{Form::label('name',__('Phone'),['class'=>'form-label']) }}
            <div class="intl-tel-input">
                <input type="tel" id="phone-input" name="phone" class="phone-input form-control"
                    placeholder="Enter Phone" maxlength="16" required>
                <input type="hidden" name="countrycode" id="country-code">
            </div>
        </div>
    </div>
    <div class="col-6 need_full">
        <div class="form-group ">
            {{Form::label('name',__('Gender'),['class'=>'form-label']) }}
            {!! Form::select('gender', $gender, null,array('class' => 'form-control','required'=>'required')) !!}
        </div>
    </div>
    <!-- <hr class ="mb-4"> -->
    <hr>
    <div class="col-12 p-0 modaltitle pb-3 mb-3">
        <!-- <hr> -->
        <h5 style="margin-left: 14px;">{{__('Login Details')}}</h5>
        <!-- <hr class ="mt-3"> -->
    </div>
    <div class="col-6 need_full">
        <div class="form-group">
            {{Form::label('email',__('Email'),['class'=>'form-label']) }}
            {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter Email'),'required'=>'required'))}}
        </div>
    </div>
    <div class="col-md-6 need_full">
        <div class="form-group">
            {{Form::label('name',__('Password'),['class'=>'form-label']) }}
            {{Form::password('password',array('class'=>'form-control','placeholder'=>__('Enter Password'),'required'=>'required'))}}
        </div>
    </div>
    <div class="col-6 need_full">
        <div class="form-group">
            {{Form::label('user_roles',__('Roles'),['class'=>'form-label']) }}
            {!! Form::select('user_roles', $roles, null,array('class' => 'form-control ','required'=>'required')) !!}
        </div>
    </div>
    <div class="col-6 need_full">
        <div class="form-group" style="margin-top: 35px;">
            {{Form::label('name',__('Active'),['class'=>'form-label']) }}
            <input type="checkbox" class="form-check-input" name="is_active" checked>
        </div>
    </div>
    <hr>
    <div class="col-12 p-0 modaltitle pb-3 mb-3">
        <h5 style="margin-left: 14px;">{{__('Avatar')}}</h5>
        <!-- <hr class ="mb-4"> -->
    </div>

    <div class="col-12 mb-3 field" data-name="avatar">
        <div class="attachment-upload">
            <div class="attachment-button">
                <div class="pull-left">
                    {{-- {{Form::file('avatar',array('class'=>'form-control'))}} --}}
                    <input type="file" name="avatar" class="form-control mb-3"
                        onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                    <img id="blah" width="25%" />
                </div>
            </div>
            <div class="attachment"></div>
        </div>
    </div>
    <hr>
    <div class="col-12 p-0 modaltitle pb-3 mb-3">
        <h5 style="margin-left: 14px;">{{__('Attachments(If Any)')}}</h5>
        <!-- <hr class ="mb-4"> -->
    </div>
    <div class="col-12">
        <div class=" form-group">
            {{Form::label('details',__('Upload Attachments'),['class'=>'form-label']) }}
            <input type="file" name="details" id="details" class="form-control">
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        {{Form::submit(__('Save'),array('class'=>'btn  btn-primary  '))}}
    </div>
</div>
{{Form::close()}}
<script>
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
@endif