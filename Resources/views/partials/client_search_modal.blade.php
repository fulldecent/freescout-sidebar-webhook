<div class="modal" style="padding-top: 10rem;z-index: 1000000" tabindex="-1" role="dialog" id="connect-modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ __('Connect Client') }}</h4>
            </div>
            <div class="modal-body">
                <div class="global-search">
                    <div class="global-search-input">
                        <input id="searchInput" type="text" class="form-control border-0 search-input"
                            placeholder="🔍  Search...">
                    </div>
                    <div id="globalSearchResults" class="global-search-container position-relative"
                        style="display: none;">
                        <div id="clientResults" class="global-search-results">
                            <div id="clientCategory" class="search-result-category"></div>
                        </div>
                        <div id="municipalityResults" class="global-search-results">
                            <div id="municipalityCategory" class="search-result-category"></div>
                        </div>
                        <button id="cancelButton" class="btn btn-link float-end me-2 mb-2">cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .search-input.focus-visible .global-search-results {
        display: block;
    }

    .global-search-container {
        /* Add styles for .global-search-container here */
    }

    .global-search-results {
        background-color: white;
        position: absolute;
        width: 100%;
        z-index: 999;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        border: 2px solid whitesmoke;
    }

    .global-search-results .search-result-item:hover {
        background-color: whitesmoke;
        border-radius: 5px;
    }
</style>