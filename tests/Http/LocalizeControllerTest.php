<?php

namespace MemoChou1993\Localize\Tests\Http;

use MemoChou1993\Localize\Facades\Localize;
use MemoChou1993\Localize\Tests\TestCase;

class LocalizeControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function testSync(): void
    {
        $this
            ->withHeaders([
                'Authorization' => sprintf('Bearer %s', config('localize.api_key')),
            ])
            ->json('GET', config('localize.path'))
            ->assertNoContent();

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

        $this
            ->withHeaders([
                'Authorization' => sprintf('Bearer %s', config('localize.api_key')),
            ])
            ->json('DELETE', config('localize.path'))
            ->assertNoContent();

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
