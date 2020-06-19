<?php

namespace MemoChou1993\Lexicon\Tests\Console;

use MemoChou1993\Lexicon\Facades\Lexicon;
use MemoChou1993\Lexicon\Tests\TestCase;

class CommandTest extends TestCase
{
    /**
     * @return void
     */
    public function testSync(): void
    {
        $this
            ->artisan('lexicon:sync')
            ->assertExitCode(1);

        $language = Lexicon::getLanguages()->first();

        $this->assertLanguageFileExists($language);
    }

    /**
     * @return void
     */
    public function testClear(): void
    {
        Lexicon::export();

        $language = Lexicon::getLanguages()->first();

        $this->assertLanguageFileExists($language);

        $this
            ->artisan('lexicon:clear')
            ->assertExitCode(1);

        $this->assertLanguageDirectoryDoesNotExist($language);
    }
}
