<?php

namespace MemoChou\Localize\Tests;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use MemoChou\Localize\Facades\Localize;

class LocalizeTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        File::ensureDirectoryExists(config('localize.directory').'/default');
    }

    /**
     * @return void
     */
    public function testExportOnly(): void
    {
        $this->request('project');

        Localize::flush()->only('Language 1')->export();

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
        $this->request('project');

        Localize::flush()->except('Language 1')->export();

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
        $this->request('project');

        Localize::flush()->export();

        App::setLocale('Language 1');
        $this->assertEquals('Value 7', ___('Key 2'));

        App::setLocale('Language 2');
        $this->assertEquals('Value 14', ___('Key 3'));
    }

    /**
     * @return void
     */
    public function testFlush(): void
    {
        $this->request('project');

        Localize::flush();

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
        $this->assertTrue(File::isDirectory(config('localize.directory').'/default'));

        parent::tearDown();
    }
}
