<div class="conv-sidebar-block" id="swh-content">
	<img src="{{ asset('img/loader-tiny.gif') }}"/>
</div>
@section('javascript')
    @parent
	const ajaxUrl = "{{ $url }}";
	const customerEmail = "{{ $customerEmail }}";

	$(document).ready(function(){
		$.ajax({
			url: ajaxUrl,
			type: "post",
			data: { 
				"_token": "{{ csrf_token() }}",
				customerEmail: customerEmail
			}
		}).done(function(html) {
			$("#swh-content").html(html);
		});
	});
@endsection