@extends('layouts.app')
@section('hero')
<div id="content_hero" style="background-image: url({{ url('images/hero-shortcodes.jpg') }})">
	<img src="{{ url('images/scroll-arrow.svg') }}" alt="Scroll down" class="scroll">
	<div class="container">
		<div class="row blurb scrollme animateme" data-when="exit" data-from="0" data-to="1" data-opacity="0" data-translatey="100">
			<div class="col-md-9">
				<span class="title">Edit</span>
				<h1>{{ $show->name }}</h1>
			</div>
		</div>
	</div>
</div>
@endsection
@section('content')
<div class="container section">
	<form action="{{ url('show/'.$show->id) }}" method="POST">
		@csrf
		<input type="hidden" name="_method" value="PUT">
		<div class="row">
			<div class="col-md-6">
				<label for="search">Search By</label>
				<input type="text" class="form-control" name="search" value="{{ $show->search }}" id="search">
			</div>
			<div class="col-md-12">
				<br>
				<button type="submit" class="btn btn-success">Update Details</button>
			</div>
		</div>
	</form>
</div>

@endsection