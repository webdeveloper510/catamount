<div class="row">
    <div class="col-md-12">
        @foreach($docs as $doc)
        <!-- Assuming $folder and $filename are passed to the view -->
        @if(Storage::disk('public')->exists($doc->filepath))
        @if(pathinfo($doc->filepath, PATHINFO_EXTENSION) == 'pdf')
        <img src="{{ asset('extension_img/pdf.png') }}" style="    width: 10%;
    height: auto;">
        @else
        <img src="{{ asset('extension_img/doc.png') }}" style="     width: 10%;
    height: auto;">
        @endif
        <h6>{{$doc->filename}}</h6>
        <p><a href="{{ Storage::url('app/public/'.$doc->filepath) }}" download>Download File</a></p>

        @endif

        @endforeach
    </div>
</div>