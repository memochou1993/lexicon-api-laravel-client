<?php

namespace MemoChou\Localize\Tests;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use MemoChou\Localize\Facades\Localize;

class LocalizeTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('localize.host', 'http://localize.test');
        Config::set('localize.project_id', 1);
        Config::set('localize.secret_key', 'secret');
    }

    // TODO: test getLanguages
    // TODO: test hasLanguage
    // TODO: test clear

    /**
     * @param string $filename
     * @return void
     */
    private function fetch(string $filename): void
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
    public function testExportOnly(): void
    {
        $this->fetch('project_has_languages');

        Localize::only('Language 1')->clear()->export();

        App::setLocale('Language 1');

        $this->assertEquals('Value 7', ___('Key 2'));

        App::setLocale('Language 2');

        $this->assertEquals('localize.Key 3', ___('Key 3'));
    }

    /**
     * @return void
     */
    public function testExportExcept(): void
    {
        $this->fetch('project_has_languages');

        Localize::except('Language 1')->clear()->export();

        App::setLocale('Language 1');

        $this->assertEquals('localize.Key 2', ___('Key 2'));

        App::setLocale('Language 2');

        $this->assertEquals('Value 14', ___('Key 3'));
    }

    /**
     * @return void
     */
    public function testExport(): void
    {
        $this->fetch('project_has_languages');

        Localize::export();

        App::setLocale('Language 1');

        $this->assertEquals('Value 7', ___('Key 2'));

        App::setLocale('Language 2');

        $this->assertEquals('Value 14', ___('Key 3'));
    }
}
