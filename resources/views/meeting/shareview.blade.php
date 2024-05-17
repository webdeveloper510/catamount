@php
$billing = App\Models\Billing::where('event_id',$meeting->id)->exists();
@endphp
@if($billing)
<div class="row">
    <div class="col-lg-12">
        <div id="notification" class="alert alert-success mt-1">Link copied to clipboard!</div>
        <div class="">
            {{ Form::model($meeting, ['route' => ['meeting.event_info', urlencode(encrypt($meeting->id))], 'method' => 'POST','enctype'=>'multipart/form-data']) }}
            <dl class="row">
                <dt class="col-md-6"><span class="h6 text-md mb-0">{{__('Name')}}</span></dt>
                <dd class="col-md-6">
                    <input type="text" name="name" class="form-control" value="{{ $meeting->name }}" readonly>
                </dd>
                <dt class="col-md-6"><span class="h6 text-md mb-0">{{__('Recipient')}}</span></dt>
                <dd class="col-md-6">
                    <input type="text" name="email" class="form-control" value="{{ $meeting->email }}">
                </dd>
                <dt class="col-md-12"><span class="h6  mb-0">{{__('Subject')}}</span></dt>
                <dd class="col-md-12"><input type="text" name="subject" id="Subject" class="form-control" required></dd>
                <dt class="col-md-12"><span class="h6  mb-0">{{__('Content')}}</span></dt>
                <dd class="col-md-12"><textarea name="emailbody" id="emailbody" cols="30" rows="10" class="form-control"
                        required></textarea></dd>
                <dt class="col-md-12"><span class="h6  mb-0">{{__('Upload Document')}}</span></dt>
                <dd class="col-md-12"><input type="file" name="attachment" id="attachment" class="form-control"></dd>

                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class=" btn btn-success " onclick="getDataUrlAndCopy(this)"
                            data-url="{{route('meeting.signedagreement',urlencode(encrypt($meeting->id)))}}"
                            title='Copy Link'>
                            <i class="ti ti-copy"></i>
                        </button>
                        {{Form::submit(__('Share via mail'),array('class'=>'btn btn-primary'))}}
                    </div>
                </div>
            </dl>
        </div>
        {{Form::close()}}
    </div>
</div>
@else
<div class="alert alert-danger mt-1">Create Estimated Invoice For the event!
    <a href="{{route('billing.index')}}"><i class="fa fa-arrow-right" style=" float: inline-end;"></i></a>
</div>
@endif
<style>
/* input.btn.btn-primary {
    float: right;
    margin-top: 9px;
} */
#notification {
    display: none;
}

.section {
    margin: 10px;
}
</style>
<script>
function getDataUrlAndCopy(button) {
    var dataUrl = button.getAttribute('data-url');
    copyToClipboard(dataUrl);
    // alert("Copied the data URL: " + dataUrl);
}

function copyToClipboard(text) {
    /* Create a temporary input element */
    var tempInput = document.createElement("input");

    /* Set the value of the input element to the text to be copied */
    tempInput.value = text;

    document.body.appendChild(tempInput);

    /* Select the text in the input element */
    tempInput.select();

    /* Copy the selected text to the clipboard */
    document.execCommand("copy");

    /* Remove the temporary input element from the DOM */
    document.body.removeChild(tempInput);
    showNotification();
    setTimeout(hideNotification, 2000);
}

function showNotification() {
    var notification = document.getElementById('notification');
    notification.style.display = 'block';
}

function hideNotification() {
    var notification = document.getElementById('notification');
    notification.style.display = 'none';
}
</script>