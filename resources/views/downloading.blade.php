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
		<div class="col-md-12">
			<div class="table-responsive">
				<table id="aria2list" class="table table-bordered">
					<thead>
						<tr>
							<th>Download Name</th>
							<th>File Size</th>
							<th>Downloaded</th>
							<th>Download Speed</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection


@push('script')
<script type="text/javascript">

	function pcom(total,done){
		return ((done*100)/total).toFixed(2);
	}

	function formatBytes(bytes,decimals) {
		if(bytes == 0) return '0 Byte';
		var k = 1000; // or 1024 for binary
		var dm = decimals + 1 || 3;
		var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
		var i = Math.floor(Math.log(bytes) / Math.log(k));
		return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
	}

	function progressMod(id,value) {
		if(value>=100){
			$("#"+id).addClass("progress-bar-success");
			$("#"+id).removeClass("progress-bar-info active");
		}else{
			$("#"+id).removeClass("progress-bar-success");
			$("#"+id).addClass("progress-bar-info active");
		}
		$("#"+id).css('width', value + '%');
	}

	function aria2status() {
		$.ajax({
			dataType: "json",
			url: "{{ url('/aria2-ajax') }}",
			type: "GET",
			success: function(data){
				var html = '';
				$.each(data.result, function(index,value){
					html += "<tr>";
					if(value.bittorrent.info){
						html += "	<td>"+ value.bittorrent.info.name +"</td>";
					}else{
						html += "	<td> .. Name Loading .. </td>";
					}
					html += "	<td>"+ formatBytes(value.totalLength,1) +"</td>";
					html += "	<td>"+ formatBytes(value.completedLength,1) +" ("+pcom(value.totalLength,value.completedLength)+"%)</td>";
					html += "	<td>"+ formatBytes(value.downloadSpeed,1) +"</td>";
					if(value.status=='paused'){
						html += "	<td><a href='{{ url('/aria2/resume') }}?id=" + value.gid + "'>Resume</a> | <a href='{{ url('/aria2/remove') }}?id=" + value.gid + "'>Remove</a></td>";
					}else{
						html += "	<td><a href='{{ url('/aria2/pause') }}?id=" + value.gid + "'>Pause</a> | <a href='{{ url('/aria2/remove') }}?id=" + value.gid + "'>Remove</a></td>";
					}
					html += "</tr>";
					html += '<tr><td colspan="5"><div class="progress"><div id="p_' + index + '" class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"><span class="sr-only">40% Complete (success)</span></div></div></td></tr>';
				});

				if(data.result.length!=0){
					$("#aria2list").show();
					$("#aria2list>tbody").html(html);
					$.each(data.result, function(index,value){
						progressMod('p_'+index, pcom(value.totalLength,value.completedLength));
					});
				}else{
					$("#aria2list").hide();
				}
			}
		});
	}
	aria2status();
	setInterval(aria2status, 3000);
</script>
@endpush