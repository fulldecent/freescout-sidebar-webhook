function swh_load_content() {
    $('#swh-title').html('');
    $('#swh-title').parent().addClass('hide');
    $('#swh-content').addClass('hide');
    $('#swh-loader').removeClass('hide');

	fsAjax({
			action: 'loadSidebar',
            mailbox_id: getGlobalAttr('mailbox_id'),
            conversation_id: getGlobalAttr('conversation_id')
		},
		laroute.route('sidebarwebhook.ajax'),
		function(response) {
            if (typeof(response.status) != "undefined" && response.status == 'success' && typeof(response.html) != "undefined" && response.html) {
                $('#swh-content').html(response.html);

                if (typeof(response.title) != "undefined" && response.title) {
                    $('#swh-title').html(response.title);
                    $('#swh-title').parent().removeClass('hide');
                }

                $('#swh-loader').addClass('hide');
                $('#swh-content').removeClass('hide');
            } else {
                showAjaxError(response);
            }
		}, true
	);
}

$(document).ready(function() {
    if (typeof(getGlobalAttr('mailbox_id')) == "undefined" || typeof(getGlobalAttr('conversation_id')) == "undefined") {
        return;
    }

    swh_load_content();

    $('.swh-refresh').click(function(e) {
        e.preventDefault();
        swh_load_content();
    });
});
