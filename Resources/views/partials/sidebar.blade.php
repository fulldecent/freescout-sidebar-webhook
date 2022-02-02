<div class="conv-sidebar-block" id="swh-content">
	<img src="{{ asset('img/loader-tiny.gif') }}"/>
</div>
@section('javascript')
    @parent
	$(document).ready(function(){
		$.ajax({
			url: {!! $webhookUrlJson !!},
			data: {!! $payloadJson !!},
			type: "post",
		}).done(function(html) {
			$("#swh-content").html(html);
		});
	});
@endsection