<?php

namespace MemoChou1993\Localize\Tests\Console;

use MemoChou1993\Localize\Facades\Localize;
use MemoChou1993\Localize\Tests\TestCase;

class CommandTest extends TestCase
{
    /**
     * @return void
     */
    public function testSync(): void
    {
        $this
            ->artisan('localize:sync')
            ->assertExitCode(1);

        $language = Localize::getLanguages()->first();

        $this->assertLanguageFileExists($language);
    }

    /**
     * @return void
     */
    public function testClear(): void
    {
        Localize::export();

        $language = Localize::getLanguages()->first();

        $this->assertLanguageFileExists($language);

        $this
            ->artisan('localize:clear')
            ->assertExitCode(1);

        $this->assertLanguageDirectoryDoesNotExist($language);
    }
}
