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
        $this->withHeaders([
                'X-Localize-API-Key' => config('localize.api_key'),
            ])
            ->json('POST', '/api/'.config('localize.path'), [
                'events' => [
                    'sync',
                ],
            ])
            ->assertNoContent();

        $language = Localize::getLanguages()->first();

        $this->assertLanguageFileExists($language);
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
