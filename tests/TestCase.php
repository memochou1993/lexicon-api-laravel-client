<?php

namespace MemoChou1993\Lexicon\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;
use MemoChou1993\Lexicon\Lexicon;
use MemoChou1993\Lexicon\Providers\LexiconServiceProvider;
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
            LexiconServiceProvider::class,
        ];
    }

    /**
     * @param Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'lexicon' => Lexicon::class,
        ];
    }

    /**
     * @param string $language
     * @return void
     */
    protected function assertLanguageFileExists(string $language): void
    {
        $path = sprintf('%s/%s.php', $language, config('lexicon.filename'));

        $this->assertFileExists(lang_path($path));
    }

    /**
     * @param string $language
     * @return void
     */
    protected function assertLanguageFileDoesNotExist(string $language): void
    {
        $path = sprintf('%s/%s.php', $language, config('lexicon.filename'));

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
