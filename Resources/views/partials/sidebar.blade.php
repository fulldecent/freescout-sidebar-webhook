<div class="conv-sidebar-block">
    <div class="panel-group accordion accordion-empty">
        <div class="panel-heading hide">
            <h4 class="panel-title" id="swh-title"></h4>
        </div>
        <div class="panel-body">
            <div class="panel panel-default hide" id="swh-content"></div>
            <button data-toggle="modal" data-target="#connect-modal" class="btn btn-primary hide"
                id="swh-connect"></button>
            <div class="panel panel-default" id="swh-loader">
                <img src="{{ asset('img/loader-tiny.gif') }}" />
            </div>
            <div class="margin-top-10 small">
                <a href="#" class="swh-refresh sidebar-block-link"><i class="glyphicon glyphicon-refresh"></i>
                    {{ __("Refresh") }}</a>
            </div>
        </div>
    </div>
</div>
