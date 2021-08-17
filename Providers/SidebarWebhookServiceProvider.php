<?php

namespace Modules\SidebarWebhook\Providers;
use Illuminate\Support\ServiceProvider;

define('MODULE_SA', 'sidebarwebhook');

class SidebarWebhookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Behaviors documented at https://nwidart.com/laravel-modules/v6/advanced-tools/module-resources
        $this->registerViews();
        $this->hooks();
    }

    public function hooks()
    {
        \Eventy::addAction('conversation.after_prev_convs', function ($customer, $conversation, $mailbox) {
            $webhookUri = 'https://example.com/';
            $customerEmail = $customer->getMainEmail();
            if (empty($customerEmail)) {
                return;
            }
            echo \View::make('sidebarwebhook::partials/sidebar', [
                'customerEmail' => $customerEmail,
                'url'           => $webhookUri,
            ])->render();
        }, 10, 3);
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
}
