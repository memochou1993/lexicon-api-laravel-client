<?php

namespace MemoChou1993\Localize\Tests;

use Illuminate\Support\Facades\App;
use MemoChou1993\Localize\Facades\Localize;

class LocalizeControllerTest extends TestCase
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
        $this->get('localize');

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

        $this->delete('localize');

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

        parent::tearDown();
    }
}
