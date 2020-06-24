
	@if ($errors->any())
		@php $errors = $errors->all() @endphp
	@endif
	@if($errors)
		@foreach ($errors as $error)
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert">×</button>	
			<strong>{{ $error }}</strong>
		</div>
		@endforeach
	@endif

	@if ($message = session('success'))
	<div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>	
		<strong>{{ $message }}</strong>
	</div>
	@endif
	
	@if ($message = session('error'))
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">×</button>	
		<strong>{{ $message }}</strong>
	</div>
	@endif
	
	@if ($message = session('warning'))
	<div class="alert alert-warning alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>	
		<strong>{{ $message }}</strong>
	</div>
	@endif	
	
	@if ($message = session('info'))
	<div class="alert alert-info alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>	
		<strong>{{ $message }}</strong>
	</div>
	@endif
