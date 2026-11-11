<?php

declare(strict_types=1);

namespace Modules\SidebarWebhook\Tests;

use Modules\SidebarWebhook\WebhookPayload;
use PHPUnit\Framework\TestCase;

final class WebhookPayloadTest extends TestCase
{
    public function testPostsTheDocumentedFields(): void
    {
        $payload = WebhookPayload::make(
            123,
            'hello@example.com',
            ['hello@example.com', 'welcome@example.com'],
            [['n' => '', 'type' => 1, 'value' => '']],
            'Testing this sidebar',
            'Phone',
            456,
            78,
            1,
            '0C7DA918-E72C-47B2-923B-0C5BB6A6104E',
        );

        self::assertSame(
            [
                'customerId',
                'customerEmail',
                'customerEmails',
                'customerPhones',
                'conversationSubject',
                'conversationType',
                'conversationId',
                'conversationNumber',
                'mailboxId',
                'secret',
            ],
            array_keys($payload),
        );
        self::assertSame(123, $payload['customerId']);
        self::assertSame('hello@example.com', $payload['customerEmail']);
        self::assertSame(['hello@example.com', 'welcome@example.com'], $payload['customerEmails']);
        self::assertSame('Testing this sidebar', $payload['conversationSubject']);
        self::assertSame('Phone', $payload['conversationType']);
        self::assertSame(456, $payload['conversationId']);
        self::assertSame(78, $payload['conversationNumber']);
        self::assertSame(1, $payload['mailboxId']);
        self::assertSame('0C7DA918-E72C-47B2-923B-0C5BB6A6104E', $payload['secret']);
    }

    public function testKeepsAnEmptySecret(): void
    {
        $payload = WebhookPayload::make(1, 'a@example.com', [], [], 'Subject', 'Email', 2, 3, 4, '');

        self::assertSame('', $payload['secret']);
        self::assertArrayHasKey('secret', $payload);
    }

    public function testReindexesEmailAndPhoneLists(): void
    {
        $payload = WebhookPayload::make(
            1,
            'a@example.com',
            [2 => 'a@example.com'],
            [5 => ['value' => '555']],
            'Subject',
            'Email',
            2,
            3,
            4,
            '',
        );

        self::assertSame(['a@example.com'], $payload['customerEmails']);
        self::assertSame([['value' => '555']], $payload['customerPhones']);
    }
}
