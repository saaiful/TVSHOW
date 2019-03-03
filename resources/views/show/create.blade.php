@extends('layouts.app')
@section('hero')
<div id="content_hero" style="background-image: url({{ url('images/hero-shortcodes.jpg') }})">
	<img src="{{ url('images/scroll-arrow.svg') }}" alt="Scroll down" class="scroll">
	<div class="container">
		<div class="row blurb scrollme animateme" data-when="exit" data-from="0" data-to="1" data-opacity="0" data-translatey="100">
			<div class="col-md-9">
				<span class="title">Via Aria2</span>
				<h1>Downloading Now</h1>
			</div>
		</div>
	</div>
</div>
@endsection
@section('content')
<div class="container section">
	<div class="row">
		<form action="#" method="post" onsubmit="searchTvmaze();">
			<div class="col-md-12">
				<div id="tvs-search-input">
					<div class="input-group col-md-12">
						<input type="text" id="show_name" class="form-control input-lg" placeholder="Enter TV Show Name" />
						<span class="input-group-btn">
							<button onclick="searchTvmaze();" class="btn btn-info btn-lg" type="button">
								<i class="glyphicon glyphicon-search"></i>
							</button>
						</span>
					</div>
				</div>
			</div>

			<div class="col-md-12" style="margin-top: 50px;">
				<div class="row" id="results">
				</div>
			</div>
		</form>
	</div>
</div>

<form action="{{ url('/show') }}" method="POST" id="add">
	@csrf
	<input type="hidden" name="id" id="id">
</form>
@endsection

@push('script')
<script type="text/javascript">
	function searchTvmaze() {
		$.ajax({
			dataType: "json",
			url: "http://api.tvmaze.com/search/shows?q=" + $("#show_name").val(),
			type: "GET",
			success: function(data){
				var html = '';
				$.each(data,function(index,value){
					try{
						html += '<div class="col-md-3 text-center">';
						html += '	<img src="' + value.show.image.medium + '" class="img-responsive img-radio" style="width:100%; margin-bottom:15px;">';
						html += '	<button type="button" onclick="addShow(\''+ value.show.id +'\');" class="btn btn-primary btn-radio">' + value.show.name + '</button>';
						html += '	<input type="checkbox" id="left-item" class="hidden">';
						html += '</div>';
					} catch ( e ) {}
				});
				$("#results").html(html);
				searchResult();
			}
		});
	}

	function searchResult(){
	    $('.btn-radio').click(function(e) {
	        $('.btn-radio').not(this).removeClass('active')
	    		.siblings('input').prop('checked',false)
	            .siblings('.img-radio').css('opacity','0.5');
	    	$(this).addClass('active')
	            .siblings('input').prop('checked',true)
	    		.siblings('.img-radio').css('opacity','1');
	    });
	}
	function addShow(id) {
		$("#id").val(id);
		$("#add")[0].submit();
		// window.location = "{{ url('/show') }}/" + id + '/fetch';
	}

	$("form").submit(function(e){
		searchTvmaze();
        e.preventDefault();
    });
</script>
@endpush