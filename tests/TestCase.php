<?php

namespace MemoChou1993\Localize\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;
use MemoChou1993\Localize\Localize;
use MemoChou1993\Localize\Providers\LocalizeServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        File::ensureDirectoryExists(lang_path('zh-TW'));
    }

    /**
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LocalizeServiceProvider::class,
        ];
    }

    /**
     * @param Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'localize' => Localize::class,
        ];
    }

    /**
     * @param string $language
     * @return void
     */
    protected function assertLanguageFileExists(string $language): void
    {
        $path = sprintf('%s/%s.php', $language, config('localize.filename'));

        $this->assertFileExists(lang_path($path));
    }

    /**
     * @param string $language
     * @return void
     */
    protected function assertLanguageFileDoesNotExist(string $language): void
    {
        $path = sprintf('%s/%s.php', $language, config('localize.filename'));

        $this->assertFileDoesNotExist(lang_path($path));
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        $this->assertTrue(File::isDirectory(lang_path('zh-TW')));

        parent::tearDown();
    }
}
