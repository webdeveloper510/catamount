@extends('layouts.admin')
@section('page-title')
{{ __('Report') }}
@endsection
@section('title')
<div class="page-header-title">
    <h4 class="m-b-10">{{ __('Push notification') }}</h4>
</div>
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item">{{ __('Push notification') }}</li>
@endsection
@section('action-btn')

@endsection
@section('filter')
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <button onclick="startFCM()" class="btn btn-danger btn-flat"> Allow notification </button>
            <div class="card mt-3">
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form action="{{ route('send.web-notification') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Message Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Message Body</label>
                            <textarea class="form-control" name="body"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Send Notification</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('firebase-messaging-sw.js')
            .then(function(registration) {
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            })
            .catch(function(err) {
                console.error('ServiceWorker registration failed: ', err);
            });
    });
}
</script>

<script>
var firebaseConfig = {
    apiKey: "AIzaSyB3y7uzZSAP39LOIvZwOjJOdFD2myDnvQk",
    authDomain: "notify-71d80.firebaseapp.com",
    projectId: "notify-71d80",
    storageBucket: "notify-71d80.appspot.com",
    messagingSenderId: "684664764020",
    appId: "1:684664764020:web:71f82128ffc0e20e3fc321",
    measurementId: "G-FTD60E8WG9"
};
firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

function startFCM() {
    messaging
        .requestPermission()
        .then(function() {
            return messaging.getToken()
        })
        .then(function(response) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route("store.token") }}',
                type: 'POST',
                data: {
                    token: response
                },
                dataType: 'JSON',
                success: function(response) {
                    alert('Token stored.');
                },
                error: function(error) {
                    alert(error);
                },
            });
        }).catch(function(error) {
            alert(error);
        });
}
messaging.onMessage(function(payload) {
    const title = payload.notification.title;
    const options = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };
    new Notification(title, options);
});
</script>
@endsection