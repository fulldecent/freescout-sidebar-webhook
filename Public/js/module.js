function swh_load_content() {
    $("#swh-title").html("");
    $("#swh-title").parent().addClass("hide");
    $("#swh-content").addClass("hide");
    $("#swh-connect").addClass("hide");
    $("#swh-loader").removeClass("hide");

    fsAjax(
        {
            action: "loadSidebar",
            mailbox_id: getGlobalAttr("mailbox_id"),
            conversation_id: getGlobalAttr("conversation_id"),
        },
        laroute.route("sidebarwebhook.ajax"),
        function (response) {
            if (
                typeof response.status != "undefined" &&
                response.status == "success" &&
                typeof response.html != "undefined" &&
                response.html
            ) {
                if (response.html === "not-found") {
                    $("#swh-connect").html('<span>Connect to Client</span>');

                    $("#swh-loader").addClass("hide");
                    $("#swh-connect").removeClass("hide");
                    $("#swh-content").addClass("hide");
                } else {
                    $("#swh-content").html(response.html);

                    // Find a <title> element inside the response and display it
                    title = $("#swh-content").find("title").first().text();

                    if (title) {
                        $("#swh-title").html(title);
                        $("#swh-title").parent().removeClass("hide");
                    }

                    $("#swh-loader").addClass("hide");
                    $("#swh-connect").addClass("hide");
                    $("#swh-content").removeClass("hide");
                }
            } else {
                showAjaxError(response);
            }
        },
        true
    );
}

$(document).ready(function () {
    // If we're not actually viewing a conversation, don't try to do anything.
    if (
        typeof getGlobalAttr("mailbox_id") == "undefined" ||
        typeof getGlobalAttr("conversation_id") == "undefined"
    ) {
        return;
    }

    // If we don't have the #swh-content element, the server doesn't have a configured webhook URL.
    if ($("#swh-content").length == 0) {
        return;
    }

    swh_load_content();

    $(".swh-refresh").click(function (e) {
        e.preventDefault();
        swh_load_content();
    });
});
