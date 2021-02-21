@extends('layouts.app')
@section('hero')
<style>
.card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    padding: 15px;
}
.p-0{
    padding: 0px;
}
.movie-tabs {
    margin-bottom: 40px;
    padding-bottom: 40px;
    border-bottom: 1px solid #e8e8e8;
}
</style>
<div id="content_hero" style="background-image: url(images/hero-shortcodes.jpg)">
	<div class="container">
		<div class="row blurb scrollme animateme" data-when="exit" data-from="0" data-to="1" data-opacity="0" data-translatey="100">
			<div class="col-md-9">
				<span class="title">All Shows</span>
				<h1>Listed</h1>
			</div>
		</div>
	</div>
</div>
@endsection
@section('content')
<div class="container section negative-margin">
    <div class="card">
    	<div class="row">
    		<div class="col-sm-12 p-0">
    			<div class="live-search">
    				<form action="" method="GET">
    					<input type="text" id="search" name="q" value="{{ request()->q }}" placeholder="Type to search">
    					<i class="material-icons">search</i>
    				</form>
    			</div>
    		</div>
    		@include('msg')
    		<div class="col-sm-12">
    			@foreach($items as $show)
    			<div class="row movie-tabs">
    				<div class="col-md-2 col-sm-3">
    					<a href="single-movie.html">
    						<img src="{{ str_replace("original_untouched", "medium_portrait", $show->cover) }}" alt="{{ $show->name }}" />
    					</a>
    				</div>
    				<div class="col-md-10 col-sm-9">
    					<span class="title"># {{ $show->id }} ({{ implode(',',$show->genres) }})</span>
    					<h3 class="no-underline">{{ $show->name }}</h3>
    					{!! ($show->summary) ? $show->summary : $show->summary !!}
    					<p><a href="{{ url('show/'.$show->id) }}" class="arrow-button">All Episodes</a></p>
    					<div class="row">
    						<div class="col-md-8 col-sm-9">
    							<hr class="space-10" />
    							<span class="viewing-times">
    								<i class="material-icons">access_time</i>
    								{{ date('h:i a', strtotime($show->schedule)) }}
    							</span>
    							@if(date('Y-m-d')>=$show->schedule)
    							@if($show->magnet)
    							<span class="time"><a href="{{ url('download?id='.$show->id.'&download=yes&force=yes') }}"><i class="material-icons">cloud_download</i> Re Download</a></span>
    							<span class="time"><a href="{{ url('download?id='.$show->id.'&download=yes') }}"><i class="material-icons">whatshot</i> Aria2 Download</a></span>
    							@else
    							<span class="time"><a href="{{ url('download?id='.$show->id.'&download=yes') }}"><i class="material-icons">cloud_download</i> Download</a></span>
    							@endif
    							@endif
    							@if($show->magnet)
    							<span class="time"><a href="{{ $show->magnet }}"><i class="material-icons">hourglass_full</i> Margnet</a></span>
    							@endif
    						</div>
    						<div class="col-md-4 col-sm-3 running-time">
    							<hr class="space-10" />
    							25-40 mins
    						</div>
    					</div>
    				</div>
    			</div>
    			@endforeach
    		</div>
    		<div class="col-md-12">
    			{!! $items->appends(['q',request()->q])->links() !!}
    		</div>
    	</div>
    </div>
</div>
@endsection


@push('script')
<script type="text/javascript">
	if ($(".tabs").length > 0) {
        $('.tabs').tabs();
        $('.tabs.movies').tabs({
            active: {{ date('w') }}
        });
    }
</script>
@endpush