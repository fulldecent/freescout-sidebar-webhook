$(document).ready(function() {
    var searchInput = $('#searchInput');
    var globalSearchResults = $('#globalSearchResults');
    var clientCategory = $('#clientCategory');
    var municipalityCategory = $('#municipalityCategory');
    var cancelButton = $('#cancelButton');
    var clients = [];
    var municipalities = [];
    var resultsFlag = false;

    searchInput.on('focus', function() {
        resultsFlag = true;
        globalSearchResults.show();
    });

    searchInput.on('input', function() {
        var searchTerm = $(this).val();
        if (searchTerm.length >= 2) {
            getSearchResults(searchTerm);
        } else {
            clearResults();
        }
    });

    cancelButton.on('click', function() {
        clearResults();
        searchInput.val('');
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
                console.log(response.data, "sdssdsd");
                if (
                    typeof response.status != "undefined" &&
                    response.status == "success" &&
                    typeof response.data != "undefined" &&
                    response.data
                ) {
                    const data = JSON.parse(response.data || '{}')
                    updateResults(data.clients, data.municipalities);
                } else {
                    showAjaxError(response);
                }
            },
            true
        );
    }

    function updateResults(newClients, newMunicipalities) {
        clients = newClients;
        municipalities = newMunicipalities;
        renderResults();
    }

    function renderResults() {
        clientCategory.empty();
        municipalityCategory.empty();

        if (clients.length > 0) {
            $.each(clients, function(index, client) {
                var clientItem = $('<div>', {
                    class: 'search-result-item client-item search-item ps-2 pe-2 py-1 d-flex',
                    'data-id': 'client' + client.id,
                    click: function() {
                        goTo('clientsEdit', client.id);
                    }
                });
                clientItem.append($('<span>', { class: 'me-2 w-50', text: client.name }));
                clientItem.append($('<span>', { class: 'me-2 w-25', text: client.county }));
                clientItem.append($('<span>', { class: 'w-25 text-end pe-2', text: client.state_abb }));
                clientCategory.append(clientItem);
            });
        }

        if (municipalities.length > 0) {
            $.each(municipalities, function(index, municipality) {
                var municipalityItem = $('<div>', {
                    class: 'search-result-item municipality-item search-item ps-2 pe-2 py-1 d-flex',
                    'data-id': 'municipality' + municipality.id,
                    click: function() {
                        goTo('municipalityEdit', municipality.id);
                    }
                });
                municipalityItem.append($('<span>', { class: 'me-2 w-50', text: municipality.full_name }));
                municipalityItem.append($('<span>', { class: 'me-2 w-25', text: municipality.county }));
                municipalityItem.append($('<span>', { class: 'w-25 text-end pe-2', text: municipality.state }));
                municipalityCategory.append(municipalityItem);
            });
        }
    }

    function clearResults() {
        clientCategory.empty();
        municipalityCategory.empty();
        globalSearchResults.hide();
        clients = [];
        municipalities = [];
    }

    function goTo(resultsType, resultId) {
        // Your logic for navigation goes here
        // Example:
        // window.location.href = resultsType + '?id=' + resultId;
        clearResults();
    }
});