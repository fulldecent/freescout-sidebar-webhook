<div class="conv-sidebar-block">
    <div class="panel-group accordion accordion-empty">
        <div class="panel panel-default">
            <div class="panel-heading hide">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href=".collapse-swh">
                        <span id="swh-title"></span>
                        <b class="caret"></b>
                    </a>
                </h4>
            </div>
            <div class="collapse-swh panel-collapse collapse in">
                <div class="panel-body">
                    <div class="sidebar-block-header2"><strong id="swh-title-mobile"></strong> (<a data-toggle="collapse" href=".collapse-swh">{{ __('close') }}</a>)</div>
                    <div class="hide" id="swh-content"></div>
                    <div id="swh-loader">
                        <img src="{{ asset('img/loader-tiny.gif') }}" />
                    </div>
                    <div class="margin-top-10 small">
                        <a href="#" class="swh-refresh sidebar-block-link"><i class="glyphicon glyphicon-refresh"></i> {{ __("Refresh") }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
