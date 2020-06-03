<?php

namespace MemoChou1993\Localize\Tests\Http;

use Illuminate\Support\Facades\File;
use MemoChou1993\Localize\Facades\Localize;
use MemoChou1993\Localize\Tests\TestCase;

class LocalizeControllerTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->prepare('project'); // TODO: should be removed
    }

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

        $this
            ->withHeaders([
                'Authorization' => sprintf('Bearer %s', config('localize.api_key')),
            ])
            ->json('DELETE', config('localize.path'))
            ->assertNoContent();

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
