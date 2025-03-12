@extends('layouts.app')

@section('content')
  <h1 id="hello" class="text-center mt-xl-5">Hello World</h1>
@endsection

@push('scripts')
<script type="module">
  $(document).ready(function() {
    console.log("Jquery Loaded")
  })
</script>
@endpush