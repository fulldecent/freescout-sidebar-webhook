<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__ . '/Http', __DIR__ . '/Providers', __DIR__ . '/tests'])
    ->name('*.php')
    ->append([__DIR__ . '/start.php', __DIR__ . '/WebhookPayload.php']);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
    ])
    ->setFinder($finder);
