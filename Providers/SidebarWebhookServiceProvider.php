<?php

namespace Modules\SidebarWebhook\Providers;

use Illuminate\Support\ServiceProvider;

class SidebarWebhookServiceProvider extends ServiceProvider
{
    private const MODULE_NAME = 'sidebarwebhook';

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', self::MODULE_NAME);
        $this->hooks();
    }

    public function registerViews()
    {
        $viewPath = resource_path('views/modules/sidebarwebhook');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/sidebarwebhook';
        }, \Config::get('view.paths')), [$sourcePath]), 'sidebarwebhook');
    }

    /**
     * Module hooks.
     */
    public function hooks()
    {
        \Eventy::addFilter('javascripts', function ($javascripts) {
            $javascripts[] = \Module::getPublicPath('sidebarwebhook') . '/js/laroute.js';
            $javascripts[] = \Module::getPublicPath('sidebarwebhook') . '/js/module.js';
            $javascripts[] = \Module::getPublicPath('sidebarwebhook') . '/js/search.js';
            return $javascripts;
        });

        \Eventy::addAction('mailboxes.settings.menu', function ($mailbox) {
            if (auth()->user()->isAdmin()) {
                echo \View::make('sidebarwebhook::partials/settings_menu', ['mailbox' => $mailbox])->render();
            }
        }, 34);

        // Settings view.
        \Eventy::addFilter('settings.view', function ($view, $section) {
            if ($section != 'sidebarwebhook') {
                return $view;
            } else {
                return 'sidebarwebhook::settings';
            }
        }, 20, 2);

        \Eventy::addAction('conversation.after_prev_convs', function ($customer, $conversation, $mailbox) {
            $url = \Option::get('sidebarwebhook.url')[(string)$mailbox->id] ?? '';

            if ($url != '') {
                echo \View::make(self::MODULE_NAME . '::partials/sidebar', [])->render();
                echo \View::make(self::MODULE_NAME . '::partials/client_search_modal', [])->render();
            }
        }, -1, 3);
    }
}
