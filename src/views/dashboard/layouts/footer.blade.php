@section('footer')
	<script src="{{ asset('vendors/jquery-3.3.1.min.js') }}"></script>
	<script src="{{ asset('vendors/popper.min.js') }}"></script>
	<script src="{{ asset('vendors/bootstrap-4.2.1/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('vendors/iziToast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery-touchswipe/jquery.touchSwipe.min.js') }}"></script>
	<script src="{{ asset('js/dashio.min.js') . '?v=' . filemtime(public_path('js/main.js'))  }}"></script>
	<script src="{{ asset('js/main.js') . '?v=' . filemtime(public_path('js/main.js'))  }}"></script>
@show