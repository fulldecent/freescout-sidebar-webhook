$(document).ready(function () {
  const searchInput = $("#search-input");
  const globalSearchResults = $("#global-search-results");
  const clientResults = $("#client-results");
  const cancelButton = $("#cancel-button");
  let clients = [];
  let user = '';
  let searchTerm = '';

  searchInput.on("input", function () {
    searchTerm = $(this).val();
    if (searchTerm.length >= 1) {
      getSearchResults(searchTerm);
    } else {
      clearResults();
    }
  });

  cancelButton.on("click", function () {
    clearResults();
    searchInput.val("");
  });

  function getSearchResults(searchTerm) {
    fsAjax(
      {
        action: "searchClient",
        search: searchTerm,
        mailbox_id: getGlobalAttr("mailbox_id"),
        conversation_id: getGlobalAttr("conversation_id"),
      },
      laroute.route("sidebarwebhook.ajax"),
      function (response) {
        if (
          typeof response.status != "undefined" &&
          response.status == "success" &&
          typeof response.data != "undefined" &&
          response.data
        ) {
          const data = JSON.parse(response.data || "{}");
          user = response.user || {};
          updateResults(data.clients);
        } else {
          showAjaxError(response);
        }
      },
      true
    );
  }

  function updateResults(newClients) {
    clients = newClients;
    renderResults();
  }

  function renderResults() {
    clientResults.empty();

    if (clients.length > 0) {
      $("#new-client-button").addClass("hide");
      clientResults.append(
        $("<h4>", {
          class: "",
          text: `Clients`,
        })
      );
      $.each(clients, function (index, client) {
        const clientItem = $("<div>", {
          class: "search-result-item search-item",
          "data-id": "client" + client.id,
          click: function () {
            goClient(client.id, "add_contact");
          },
        });
        clientItem.append(
          $("<span>", {
            class: "",
            text: `${client.name}, ${client.county}, ${client.state_abb}`,
          })
        );
        clientResults.append(clientItem);
        globalSearchResults.show();
      });
    } else {
      clientResults.append(
        $("<h4>", {
          class: "",
          text: `Client not found. Click the "Add New Client" button to add client`,
        })
      );
      globalSearchResults.show();
      $("#new-client-button").html(
        $("<button>", {
          class: "btn btn-primary",
          text: `Add New Client`,
          click: function () {
            window.open(
              `https://mc2.townweb.com/clients?action=new_client&name=${searchTerm}`,
              "_blank"
            );
          },
        })
      );
      $("#new-client-button").removeClass("hide");
    }
  }

  function clearResults() {
    clientResults.empty();
    globalSearchResults.hide();
    $("#new-client-button").addClass("hide");
    clients = [];
  }

  function goClient(id, action) {
    window.open(
      `https://mc2.townweb.com/clients/edit/${id}?action=${action}&${objectToQuery(user)}`,
      "_blank"
    );
    clearResults();
  }

  function objectToQuery(obj) {
    return Object.entries(obj).map(([key, val]) => `${encodeURIComponent(key)}=${encodeURIComponent(val)}`).join('&');
  }
});
