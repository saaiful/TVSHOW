@extends('layouts.app')
@section('hero')
<div id="content_hero" style="background-image: url({{ url('images/hero-shortcodes.jpg') }})">
	<img src="{{ url('images/scroll-arrow.svg') }}" alt="Scroll down" class="scroll">
	<div class="container">
		<div class="row blurb scrollme animateme" data-when="exit" data-from="0" data-to="1" data-opacity="0" data-translatey="100">
			<div class="col-md-9">
				<span class="title">All Shows</span>
				<h1>Update Info</h1>
			</div>
		</div>
	</div>
</div>
@endsection
@section('content')
<div class="container section">
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table id="aria2list" class="table table-bordered">
					<thead>
						<tr>
							<th>Show Name</th>
							<th>TVMaze ID</th>
							<th>IMDB ID</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<tbody>
							@foreach($shows as $show)
							<tr id="col_{{ $show->id }}">
								<td>{{ $show->name }}</td>
								<td>{{ $show->tvmaze_id }}</td>
								<td>{{ $show->imdb_id}}</td>
								<td id="status_{{ $show->id }}">Pending</td>
							</tr>
							@endforeach
						</tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection


@push('script')
<script type="text/javascript">
window.shows = {!! $shows !!};
function updateInfo(){
	if(typeof window.shows[0] =='object'){
		var show = window.shows[0];
		window.show = show;
		$.ajax({
	        url: "{{ url('show/') }}/" + show.id + '/fetch',
	        type: 'GET',
	        async: true,
	        timeout: 30000,
	        dataType:'html',
	        success: function(msg){ 
	            window.shows.splice(0, 1);
	            $("#status_" + window.show.id).text('Updated');
	            $("#col_" + window.show.id).addClass('success');
	            return updateInfo();
	        }
    	});
	}else{
		console.log('end');
	}
}
updateInfo();
</script>
@endpush