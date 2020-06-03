<?php

namespace MemoChou1993\Localize\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use MemoChou1993\Localize\Facades\Localize;
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

        Config::set([
            'localize.api_url' => getenv('LOCALIZE_API_URL'),
            'localize.api_key' => getenv('LOCALIZE_API_KEY'),
        ]);

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
     * @param string $filename
     * @return void
     */
    protected function prepare(string $filename): void
    {
        Http::fake(function () use ($filename) {
            $data = file_get_contents(__DIR__.'/data/'.$filename.'.json');

            $body = json_decode($data, true);

            return Http::response($body);
        });
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        Localize::clear();

        $this->assertTrue(File::isDirectory(lang_path('zh-TW')));

        parent::tearDown();
    }
}
