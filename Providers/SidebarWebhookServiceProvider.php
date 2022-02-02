<?php

namespace Modules\SidebarWebhook\Providers;
use Illuminate\Support\ServiceProvider;

class SidebarWebhookServiceProvider extends ServiceProvider
{
    private const MODULE_NAME = 'sidebarwebhook';
    private const WEBHOOK_URL = 'https://example.com/';

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/views', self::MODULE_NAME);
        
        \Eventy::addAction('conversation.after_prev_convs', function($customer, $conversation, $mailbox) {
            $payload = [
                'customerEmail'       => $customer->getMainEmail(),
                'customerPhones'      => $customer->getPhones(),
                'conversationSubject' => $conversation->getSubject(),
                'conversationType'    => $conversation->getTypeName(),
                'mailboxId'           => $mailbox->id,
                'csrfToken'           => csrf_token(),
            ];

            echo \View::make(self::MODULE_NAME . '::partials/sidebar', [
                'webhookUrlJson' => json_encode(self::WEBHOOK_URL),
                'payloadJson' => json_encode($payload),
            ])->render();
        }, -1, 3);
    }
}
