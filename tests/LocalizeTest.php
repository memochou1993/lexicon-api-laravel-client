<?php

namespace MemoChou1993\Localize\Tests;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Translation\Translator;
use MemoChou1993\Localize\Facades\Localize;

class LocalizeTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        File::ensureDirectoryExists(resource_path('lang/zh-TW'));

        $this->prepare('project');
    }

    /**
     * @return void
     */
    public function testGetLanguages(): void
    {
        $languages = [
            'Language 1',
            'Language 2',
        ];

        $this->assertEquals($languages, Localize::getLanguages()->toArray());
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

        $this->assertTrue(File::exists(resource_path('lang/Language 1')));
        $this->assertFalse(File::exists(resource_path('lang/Language 2')));
    }

    /**
     * @return void
     */
    public function testExportExcept(): void
    {
        Localize::except('Language 1')->export();

        $this->assertFalse(File::exists(resource_path('lang/Language 1')));
        $this->assertTrue(File::exists(resource_path('lang/Language 2')));
    }

    /**
     * @return void
     */
    public function testExport(): void
    {
        Localize::export();

        $this->assertTrue(File::exists(resource_path('lang/Language 1')));
        $this->assertTrue(File::exists(resource_path('lang/Language 2')));
    }

    /**
     * @return void
     */
    public function testClear(): void
    {
        Localize::export();

        $this->assertTrue(File::exists(resource_path('lang/Language 1')));
        $this->assertTrue(File::exists(resource_path('lang/Language 2')));

        Localize::clear();

        $this->assertFalse(File::exists(resource_path('lang/Language 1')));
        $this->assertFalse(File::exists(resource_path('lang/Language 2')));
    }

    /**
     * @return void
     */
    public function testTrans(): void
    {
        Localize::export();

        $this->assertTrue(Localize::trans() === '');
        $this->assertTrue(___() === null);
        $this->assertTrue(localize() === app(Translator::class));

        App::setLocale('Language 1');
        $this->assertEquals('Value 7', Localize::trans('Key 2'));
        $this->assertEquals('Value 7', ___('Key 2'));
        $this->assertEquals('Value 7', localize('Key 2'));

        App::setLocale('Language 2');
        $this->assertEquals('Value 14', Localize::trans('Key 3'));
        $this->assertEquals('Value 14', ___('Key 3'));
        $this->assertEquals('Value 14', localize('Key 3'));
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        Localize::clear();

        $this->assertTrue(File::isDirectory(resource_path('lang/zh-TW')));

        parent::tearDown();
    }
}
