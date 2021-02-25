@extends('layouts.app')
@section('hero')
<div id="content_hero" style="background-image: url({{ url($show->cover) }}">
	<img src="{{ url('images/scroll-arrow.svg') }}" alt="Scroll down" class="scroll" />
	<div class="container">
		<div class="row blurb scrollme animateme" data-when="exit" data-from="0" data-to="1" data-opacity="0" data-translatey="100">
			<div class="col-md-9">
				<span class="title">{{ implode(',',$show->genres) }}</span>
				<h1>{{ $show->name }}</h1>
				{!! $show->summary !!}
			</div>
		</div>
	</div>
</div>
@endsection
@section('content')
<div class="container section single-movie">
	<div class="row">
		@include('msg')
		<div class="col-sm-7">
			<h2>Synopsis</h2>
			<div class="row">
				<div class="col-sm-5 text-center">
					<img src="{{ str_replace("original_untouched", "medium_portrait", $show->cover) }}" alt="{{ $show->name }}" class="poster">
					<a href="{{ url('show/'.$show->id.'/fetch') }}" class="btn btn-default">
						<i class="material-icons">update</i>
						<span>Update Details</span>
					</a>
					<br>
					<br>
					<a href="{{ url('show/'.$show->id.'/edit') }}" class="btn btn-default">
						<i class="material-icons">edit</i>
						<span>Edit Details</span>
					</a>
				</div>
				<div class="col-sm-7">
					<h3 class="no-underline">The plot</h3>
					{!! $show->summary !!}
					<ul class="movie-info">
						<li><i>Season</i> {{ $show->season }}</li>
						<li><i>Episode</i> {{ $show->episode }}</li>
						<li><i>Air at</i> {{ date('h:i A', strtotime($show->schedule)) }}</li>
					</ul>						
				</div>
			</div>
		</div>
		<div class="col-sm-5">
			<h2>Last 5 Episodes</h2>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Season & Episode</th>
						<th>Name</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody class="movie-tabs">
					@foreach($last as $item)
					<tr>
						<td>{{ sprintf("S%02dE%02d", $item->season, $item->episode) }}</td>
						<td>{{ $item->name }}</td>
						<td class="text-center">
							@if($item->magnet)
							<a href="{{ $item->magnet }}"><span class="certificate">M</span></a>
							@endif
							@if(env('DOWNLOAD'))
							<a href="{{ url('download?id='.$item->id.'&download=yes&force=yes') }}"><span class="certificate">D</span></a>
							@endif
						</td>
					</tr>
					<tr>
						<td colspan="3">Aired at {{ $item->schedule }} {{ date('h:i A', strtotime($show->schedule)) }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php $all = []; ?>
<div class="container section single-movie">
	<div class="row">
		<div class="col-sm-12">
			@foreach($seasons as $key => $season)
			<h2>Season {{ sprintf("%02d", $season->season) }} - <a href="javascript:{};"  onclick="downloadAll({{ $season->season }});">Download All</a></h2>
			<table class="table table-bordered table-inverse">
				<thead>
					<tr>
						<th>#</th>
						<th>Show Name</th>
						<th class="text-center">Aired at</th>
						<th class="text-center">Season & Episode</th>
						<th class="text-right">Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach(App\Episode::where('show_id', $show->id)->where('season',$season->season)->orderBy('id','desc')->get() as $xxx=> $ep)
					<?php $all[$season->season][$ep->episode]= url('download?id='.$ep->id.'&download=yes&force=yes'); ?>
					<tr class="{{ ($ep->schedule<=date('Y-m-d'))?'success':'' }}">
						<td>{{ $ep->id }}</td>
						<td>{{ $ep->name }}</td>
						<td class="text-center">{{ $ep->schedule }}</td>
						<td class="text-center">{{ sprintf("S%02dE%02d", $ep->season,$ep->episode) }}</td>
						<td class="text-center">
							<?php 
								$links = [];
								if($ep->magnet){
									$links[] = '<a href="'.url('download?id='.$ep->id.'&download=yes&force=yes').'">Re Download</a>';
									$links[] = '<a href="'.$ep->magnet.'">Margnet</a>';
								}
								if(!$ep->magnet){
									$links[] = '<a href="'.url('download?id='.$ep->id.'&download=yes').'">Download</a>';
								}
								if(env('DOWNLOAD') && $ep->magnet){
									$links[] = '<a href="'.url('download?id='.$ep->id.'&download=yes').'">Aria2 Download</a>';
								}
							?>
							{!! implode("&nbsp;|&nbsp", $links) !!}
						</td>
					</tr>
					@if($ep->summary)
					<tr>
						<td colspan="5">{!! $ep->summary !!}</td>
					</tr>
					@endif
					@endforeach
				</tbody>
			</table>
			@endforeach
		</div>
	</div>
</div>
@endsection


@push('script')
<script type="text/javascript">
	var data = {!! json_encode($all) !!};
	function downloadAll(session){
		$.each(data[session], function(i,v){
			console.log(v);
			$.ajax({
				method: "GET",
				url: v,
				success: function(data){
			
				},error: function(data){
			
				}
			});
		});
	}
</script>
@endpush