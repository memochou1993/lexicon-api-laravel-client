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
        File::cleanDirectory(lang_path());

        parent::tearDown();
    }
}
