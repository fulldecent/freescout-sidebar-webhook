<?php

declare(strict_types=1);

namespace Modules\SidebarWebhook\Tests;

use PHPUnit\Framework\TestCase;

final class ModuleManifestTest extends TestCase
{
    public function testReleaseFilesAgree(): void
    {
        $root = dirname(__DIR__);
        $module = json_decode((string) file_get_contents($root . '/module.json'), true);
        $versionTxt = trim((string) file_get_contents($root . '/version.txt'));

        self::assertIsArray($module);
        self::assertSame('Sidebar Webhook', $module['name']);
        self::assertIsString($module['version']);
        self::assertIsString($module['latestVersionUrl']);
        self::assertIsString($module['latestVersionZipUrl']);
        self::assertMatchesRegularExpression('/^[0-9]+\.[0-9]+\.[0-9]+$/', $module['version']);
        self::assertSame($module['version'], $versionTxt);
        self::assertStringEndsWith('/version.txt', $module['latestVersionUrl']);
        self::assertStringEndsWith('/SidebarWebhook.zip', $module['latestVersionZipUrl']);
    }
}
