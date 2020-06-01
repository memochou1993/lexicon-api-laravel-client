<?php

namespace MemoChou1993\Localize\Tests;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use MemoChou1993\Localize\Facades\Localize;

class LocalizeTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        File::ensureDirectoryExists(
            config('localize.directory').'/zh-TW'
        );

        $this->prepare('project');
    }

    /**
     * @return void
     */
    public function testGetLanguages(): void
    {
        $expected = [
            'Language 1',
            'Language 2',
        ];

        $actual = Localize::getLanguages()->toArray();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function testHasLanguages(): void
    {
        $this->assertTrue(Localize::hasLanguage('Language 1'));
        $this->assertFalse(Localize::hasLanguage('Language 3'));
    }

    /**
     * @return void
     */
    public function testExportOnly(): void
    {
        Localize::only('Language 1')->export();

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
        Localize::except('Language 1')->export();

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
        Localize::export();

        App::setLocale('Language 1');
        $this->assertEquals('Value 7', ___('Key 2'));

        App::setLocale('Language 2');
        $this->assertEquals('Value 14', ___('Key 3'));
    }

    /**
     * @return void
     */
    public function testClear(): void
    {
        Localize::export();

        Localize::clear();

        App::setLocale('Language 1');
        $this->assertEquals('localize.Key 2', ___('Key 2'));

        App::setLocale('Language 2');
        $this->assertEquals('localize.Key 3', ___('Key 3'));
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        Localize::clear();

        $this->assertTrue(
            File::isDirectory(config('localize.directory').'/zh-TW')
        );

        parent::tearDown();
    }
}
