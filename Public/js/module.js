function swh_page_nonce() {
  var content = $('meta[http-equiv="Content-Security-Policy"]').attr("content") || "";
  var match = content.match(/'nonce-([^']+)'/);

  if (!match || !/^[A-Za-z0-9]+$/.test(match[1])) {
    return "";
  }

  return match[1];
}

// The webhook returns HTML. Inline scripts run only with the conversation
// page's nonce, which the webhook cannot see. innerHTML does not run scripts,
// so each script is created here and given that nonce.
function swh_insert_html(html) {
  var nonce = swh_page_nonce();
  var holder = document.createElement("div");
  holder.innerHTML = html;
  var scripts = Array.prototype.slice.call(holder.querySelectorAll("script")).map(function (oldScript) {
    var spec = {
      type: oldScript.getAttribute("type") || "",
      src: oldScript.getAttribute("src") || "",
      text: oldScript.textContent || "",
    };
    oldScript.parentNode.removeChild(oldScript);
    return spec;
  });
  var target = document.getElementById("swh-content");
  target.innerHTML = holder.innerHTML;
  scripts.forEach(function (spec) {
    var script = document.createElement("script");
    if (nonce) {
      script.nonce = nonce;
    }
    if (spec.type) {
      script.type = spec.type;
    }
    if (spec.src) {
      script.src = spec.src;
    } else {
      script.text = spec.text;
    }
    target.appendChild(script);
  });
}

function swh_set_title(title) {
  $("#swh-title").text(title);
  $("#swh-title-mobile").text(title);
  if (title) {
    $("#swh-title").closest(".panel-heading").removeClass("hide");
  }
}

var swhLoading = false;

function swh_load_content() {
  // Each call holds a PHP worker until the webhook returns. Ignore a second
  // refresh until this one finishes so clicks cannot fill the worker pool.
  if (swhLoading) {
    return;
  }
  swhLoading = true;

  // A refresh keeps the heading. Only the first load, before a title exists, hides it.
  if (!$.trim($("#swh-title").text())) {
    $("#swh-title").closest(".panel-heading").addClass("hide");
  }
  $("#swh-content").addClass("hide");
  $("#swh-loader").removeClass("hide");

  function finished() {
    swhLoading = false;
    $("#swh-loader").addClass("hide");
  }

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
        swh_insert_html(response.html);

        // Find a <title> element inside the response and display it
        var title = $("#swh-content").find("title").first().text();

        if (title) {
          swh_set_title(title);
        }

        finished();
        $("#swh-content").removeClass("hide");
      } else {
        finished();
        showAjaxError(response);
      }
    },
    true,
    function () {
      finished();
      showAjaxError({});
    },
  );
}

$(document).ready(function () {
  // If we're not actually viewing a conversation, don't try to do anything.
  if (typeof getGlobalAttr("mailbox_id") == "undefined" || typeof getGlobalAttr("conversation_id") == "undefined") {
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
