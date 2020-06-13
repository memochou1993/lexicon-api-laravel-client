<?php

namespace MemoChou1993\Localize\Tests\Http;

use MemoChou1993\Localize\Facades\Localize;
use MemoChou1993\Localize\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class EventControllerTest extends TestCase
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
            ->assertStatus(Response::HTTP_ACCEPTED);

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
