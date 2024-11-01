@extends('app')

@section('content')

    <!-- Container (Contact Section) -->
    <div id="contact" class="container">
        <h1 class="text-center" style="margin-top: 100px">Image Upload</h1>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <strong>{{ $message }}</strong>
            </div>
            <img src="{{ asset('images/'.Session::get('image')) }}" alt="Uploaded Image" />
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <strong>{{ $message }}</strong>
            </div>
        @endif

        <form method="POST" action="{{ route('image.store', $pengguna->id) }}" enctype="multipart/form-data">
            @csrf
            <input type="file" class="form-control" name="image" required />

            <button type="submit" class="btn btn-sm btn-primary">Upload</button>
        </form>
    </div>
@endsection
