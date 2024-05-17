@php
$files = Storage::files('app/public/UserInfo/'.$user->id);
@endphp

<div class="row">
    <div class="col-md-12">
        @foreach ($files as $file)
            <div>
                <!-- Display file name -->
                <p>{{ basename($file) }}</p>
                <div>

                <!-- Display preview if it's a PDF -->
                @if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf')
                    <iframe src="{{ Storage::url($file) }}" width="50%" height="300px"></iframe>
                @else
                <img src="{{ asset('extension_img/images.png') }}" alt="File" style="max-width: 100px; max-height: 150px;">
                    <!-- Placeholder icon for non-PDF files -->
                    <a href="{{ Storage::url($file) }}" download style=" position: absolute;"> <i class="fa fa-download"></i></a>

                @endif
                <form action="{{ route('user.docs.delete', ['id' => $user->id, 'filename' => basename($file)]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: red; cursor: pointer;"><i class="fa fa-trash"></i></button>
                    </form>
                <!-- Download link -->
                </div>

            </div>
        @endforeach
    </div>
</div>
