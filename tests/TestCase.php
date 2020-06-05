<?php

namespace MemoChou1993\Localize\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;
use MemoChou1993\Localize\Localize;
use MemoChou1993\Localize\LocalizeServiceProvider;
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
    protected function assertLanguageDirectoryExists(string $language): void
    {
        $this->assertDirectoryExists(lang_path($language));
    }

    /**
     * @param string $language
     * @return void
     */
    protected function assertLanguageDirectoryDoesNotExist(string $language): void
    {
        $this->assertDirectoryDoesNotExist(lang_path($language));
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
