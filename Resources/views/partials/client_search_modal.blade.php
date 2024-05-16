<div class="modal" style="padding-top: 10rem;" tabindex="-1" role="dialog" id="connect-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ __('Connect Client') }}</h4>
            </div>
            <div class="modal-body">
                <div id="new-client-button" class="new-client-button hide"></div>
                <div class="global-search">
                    <div class="global-search-input">
                        <input id="search-input" type="text" class="form-control border-0 search-input"
                            placeholder="🔍  Search...">
                    </div>
                    <div id="global-search-results" class="global-search-container" style="display: none;">
                        <div id="" class="global-search-results">
                            <div id="client-results" class="search-result-category"></div>
                        </div>
                    </div>
                </div>
            </div>
            <button id="cancel-button" class="btn btn-link">cancel</button>
        </div>
    </div>
</div>

<style>
    .btn-link {
        z-index: 20;
        position: absolute;
        bottom: 20px;
        right: 15px;
        margin-right: 0.5rem;
    }
    .new-client-button {
        padding-bottom: 10px;
    }
    .search-input.focus-visible .global-search-results {
        display: block;
    }
    .global-search-container {
        overflow: auto;
        position: relative;
        min-height: 150px;
    }

    .global-search-results {
        background-color: white;
        position: absolute;
        width: 100%;
        z-index: 1;
        padding: 10px;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        border: 2px solid whitesmoke;
    }

    .global-search-results .search-result-item:hover {
        background-color: whitesmoke;
        border-radius: 5px;
    }

    .search-item {
        cursor: pointer;
        padding: 5px;
    }

    .modal-backdrop {
        z-index: -5;
    }
</style>