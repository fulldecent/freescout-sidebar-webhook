<form class="form-horizontal margin-top margin-bottom" method="POST" action="">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('settings.sidebarwebhook->url') ? ' has-error' : '' }}">
        <label class="col-sm-2 control-label">{{ __('Webhook URL') }}</label>

        <div class="col-sm-6">
            <div class="input-group input-sized-lg">
                <input type="text" class="form-control input-sized-lg" name="settings[sidebarwebhook.url]" value="{{ old('settings') ? old('settings')['sidebarwebhook.url'] : $settings['sidebarwebhook.url'] }}">
            </div>

            @include('partials/field_error', ['field'=>'settings.sidebarwebhook->url'])

            <p class="form-help">
                {{ __('Example') }}: https://example.org/webhook
            </p>
        </div>
    </div>

    <div class="form-group{{ $errors->has('settings.sidebarwebhook->globalSearchUrl') ? ' has-error' : '' }}">
        <label class="col-sm-2 control-label">{{ __('Global Search URL') }}</label>

        <div class="col-sm-6">
            <div class="input-group input-sized-lg">
                <input type="text" class="form-control input-sized-lg" name="settings[sidebarwebhook.globalSearchUrl]" value="{{ old('settings') ? old('settings')['sidebarwebhook.globalSearchUrl'] : $settings['sidebarwebhook.globalSearchUrl'] }}">
            </div>

            @include('partials/field_error', ['field'=>'settings.sidebarwebhook->globalSearchUrl'])

            <p class="form-help">
                {{ __('Example') }}: https://example.org/search
            </p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">{{ __('Secret') }}</label>

        <div class="col-sm-6">
            <input type="text" class="form-control input-sized-lg" name="settings[sidebarwebhook.secret]" value="{{ $settings['sidebarwebhook.secret'] }}">

            <p class="form-help">
                {{ __('You can choose an arbitrary string. This string will be sent as a parameter to authenticate requests.') }}
            </p>
        </div>
    </div>

    <div class="form-group margin-top margin-bottom">
        <div class="col-sm-6 col-sm-offset-2">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>
        </div>
    </div>
</form>
