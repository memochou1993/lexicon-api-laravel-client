<?php

namespace MemoChou1993\Localize\Tests\Console;

use Illuminate\Support\Facades\File;
use MemoChou1993\Localize\Facades\Localize;
use MemoChou1993\Localize\Tests\TestCase;

class LocalizeCommandTest extends TestCase
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
    public function testExport(): void
    {
        $this->artisan('localize:export');

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

        $this->artisan('localize:clear');

        $this->assertFalse(File::exists(resource_path('lang/Language 1')));
        $this->assertFalse(File::exists(resource_path('lang/Language 2')));
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        Localize::clear();

        parent::tearDown();
    }
}
