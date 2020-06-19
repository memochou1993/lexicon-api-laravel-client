<?php

namespace MemoChou1993\Lexicon\Tests\Http;

use MemoChou1993\Lexicon\Facades\Lexicon;
use MemoChou1993\Lexicon\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class EventControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function testSync(): void
    {
        $this
            ->withHeaders([
                'X-Lexicon-API-Key' => config('lexicon.api_key'),
            ])
            ->json('POST', '/api/'.config('lexicon.path'), [
                'events' => [
                    'sync',
                ],
            ])
            ->assertStatus(Response::HTTP_ACCEPTED);

        $language = Lexicon::getLanguages()->first();

        $this->assertLanguageFileExists($language);
    }
}
