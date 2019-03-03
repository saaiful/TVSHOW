@if(isset($success))
<div class="col-md-12">
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{{ $success }}
	</div>
</div>
@elseif(isset($error))
<div class="col-md-12">
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{{ $error }}
	</div>
</div>
@elseif(isset($info))
<div class="col-md-12">
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{{ $info }}
	</div>
</div>
@elseif(isset($warning))
<div class="col-md-12">
	<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{{ $warning }}
	</div>
</div>
@endif


@if(Session::get('success'))
<div class="col-md-12">
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{{ Session::get('success') }}
	</div>
</div>
@elseif(Session::get('error'))
<div class="col-md-12">
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{{ Session::get('error') }}
	</div>
</div>
@elseif(Session::get('info'))
<div class="col-md-12">
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{{ Session::get('info') }}
	</div>
</div>
@elseif(Session::get('warning'))
<div class="col-md-12">
	<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{{ Session::get('warning') }}
	</div>
</div>
@endif