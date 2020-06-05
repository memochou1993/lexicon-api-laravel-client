<?php

namespace MemoChou1993\Localize\Tests\Console;

use MemoChou1993\Localize\Facades\Localize;
use MemoChou1993\Localize\Tests\TestCase;

class LocalizeCommandTest extends TestCase
{
    /**
     * @return void
     */
    public function testSync(): void
    {
        $this->artisan('localize:sync');

        $language = Localize::getLanguages()->first();

        $this->assertLanguageDirectoryExists($language);
    }

    /**
     * @return void
     */
    public function testClear(): void
    {
        Localize::export();

        $language = Localize::getLanguages()->first();

        $this->assertLanguageDirectoryExists($language);

        $this->artisan('localize:clear');

        $this->assertLanguageDirectoryDoesNotExist($language);
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
