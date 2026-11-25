<?php

declare(strict_types=1);

namespace Modules\SidebarWebhook;

/**
 * JSON body posted to the mailbox webhook URL.
 *
 * The FreeScout models stay in the controller. This class is the contract
 * the webhook server receives.
 */
final class WebhookPayload
{
    /**
     * @param array<mixed> $customerEmails
     * @param array<mixed> $customerPhones
     * @return array{
     *     customerId: int,
     *     customerEmail: string,
     *     customerEmails: list<mixed>,
     *     customerPhones: list<mixed>,
     *     conversationSubject: string,
     *     conversationType: string,
     *     conversationId: int,
     *     conversationNumber: int,
     *     mailboxId: int,
     *     secret: string
     * }
     */
    public static function make(
        int $customerId,
        string $customerEmail,
        array $customerEmails,
        array $customerPhones,
        string $conversationSubject,
        string $conversationType,
        int $conversationId,
        int $conversationNumber,
        int $mailboxId,
        string $secret,
    ): array {
        return [
            'customerId' => $customerId,
            'customerEmail' => $customerEmail,
            'customerEmails' => array_values($customerEmails),
            'customerPhones' => array_values($customerPhones),
            'conversationSubject' => $conversationSubject,
            'conversationType' => $conversationType,
            'conversationId' => $conversationId,
            'conversationNumber' => $conversationNumber,
            'mailboxId' => $mailboxId,
            'secret' => $secret,
        ];
    }
}
