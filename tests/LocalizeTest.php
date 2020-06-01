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
    protected function tearDown(): void
    {
        Localize::clear();

        $this->assertTrue(File::isDirectory(resource_path('lang/zh-TW')));

        parent::tearDown();
    }
}
