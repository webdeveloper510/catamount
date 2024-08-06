@extends('layouts.admin')
@section('page-title')
{{ __('Report') }}
@endsection
@section('title')
{{ __('Power BI Report') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item">{{ __('Report') }}</li>
<li class="breadcrumb-item">{{ __('Power BI Report') }}</li>
@endsection
@section('content')
<div id="embed-container" style="width:100%;height:600px;margin-top: 25px"></div>
@endsection

@push('script-page')
<script src="{{ asset('js/dist/powerbi.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if powerbi object is loaded
        if (typeof powerbi === 'undefined') {
            console.error('Power BI JavaScript SDK not loaded');
            return;
        }

        let embedContainer = document.getElementById('embed-container');
        let embedConfiguration = {
            type: 'report',
            accessToken: '{{ $accessToken }}',
            embedUrl: '{{ $embedUrl }}',
            id: '{{ $reportId }}',
            // permissions: 1,
            // tokenType: 1
        };

        // Log embedConfiguration to the console
        // console.log(embedConfiguration);

        // Embed the report
        let report = powerbi.embed(embedContainer, embedConfiguration);

        report.on('loaded', function() {
            console.log('Report loaded successfully');
        });

        report.on('error', function(event) {
            console.error('Error loading report', event.detail);
        });
    });
</script>
@endpush