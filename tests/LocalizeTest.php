<?php

namespace MemoChou1993\Localize\Tests;

use Illuminate\Support\Facades\App;
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

        $this->prepare('project');
    }

    /**
     * @return void
     */
    public function testGetLanguages(): void
    {
        $this->assertEquals('Language 1', Localize::getLanguages()->first());
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

        $this->assertLanguageDirectoryExists('Language 1');
        $this->assertLanguageDirectoryDoesNotExist('Language 2');
    }

    /**
     * @return void
     */
    public function testExportExcept(): void
    {
        Localize::except('Language 1')->export();

        $this->assertLanguageDirectoryDoesNotExist('Language 1');
        $this->assertLanguageDirectoryExists('Language 2');
    }

    /**
     * @return void
     */
    public function testExport(): void
    {
        Localize::export();

        $this->assertLanguageDirectoryExists('Language 1');
        $this->assertLanguageDirectoryExists('Language 2');
    }

    /**
     * @return void
     */
    public function testClear(): void
    {
        Localize::export();

        $this->assertLanguageDirectoryExists('Language 1');
        $this->assertLanguageDirectoryExists('Language 2');

        Localize::clear();

        $this->assertLanguageDirectoryDoesNotExist('Language 1');
        $this->assertLanguageDirectoryDoesNotExist('Language 2');
    }

    /**
     * @return void
     */
    public function testTrans(): void
    {
        Localize::export();

        $this->assertSame('', Localize::trans());
        $this->assertSame(null, ___());
        $this->assertSame(app(Translator::class), localize());

        App::setLocale('Language 1');
        $this->assertEquals('Value 7', Localize::trans('Key 2'));
        $this->assertEquals('Value 7', ___('Key 2'));
        $this->assertEquals('Value 7', localize('Key 2'));

        App::setLocale('Language 2');
        $this->assertEquals('Value 14', Localize::trans('Key 3'));
        $this->assertEquals('Value 14', ___('Key 3'));
        $this->assertEquals('Value 14', localize('Key 3'));
    }
}
