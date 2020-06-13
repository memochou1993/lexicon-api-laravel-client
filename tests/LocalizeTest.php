<?php

namespace MemoChou1993\Localize\Tests;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Translation\Translator;
use MemoChou1993\Localize\Client;
use MemoChou1993\Localize\Localize;
use PHPUnit\Framework\MockObject\MockObject;

class LocalizeTest extends TestCase
{
    /**
     * @var Localize
     */
    private Localize $localize;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->mockClient();
    }

    /**
     * @return void
     */
    protected function mockClient(): void
    {
        /** @var Client|MockObject $client */
        $client = $this->getMockBuilder(Client::class)->getMock();

        $client->expects($this->once())
            ->method('fetchProject')
            ->willReturn(
                new Response(200, [], file_get_contents(__DIR__.'/data/project.json'))
            );

        $this->localize = new Localize($client);
    }

    /**
     * @return void
     */
    public function testGetLanguages(): void
    {
        $this->assertEquals('Language 1', $this->localize->getLanguages()->first());
    }

    /**
     * @return void
     */
    public function testHasLanguages(): void
    {
        $this->assertTrue($this->localize->hasLanguage('Language 1'));
        $this->assertFalse($this->localize->hasLanguage('Language 3'));
    }

    /**
     * @return void
     */
    public function testExportOnly(): void
    {
        $this->localize->only('Language 1')->export();

        $this->assertLanguageFileExists('Language 1');
        $this->assertLanguageFileDoesNotExist('Language 2');
    }

    /**
     * @return void
     */
    public function testExportExcept(): void
    {
        $this->localize->except('Language 1')->export();

        $this->assertLanguageFileDoesNotExist('Language 1');
        $this->assertLanguageFileExists('Language 2');
    }

    /**
     * @return void
     */
    public function testExport(): void
    {
        $this->localize->export();

        $this->assertLanguageFileExists('Language 1');
        $this->assertLanguageFileExists('Language 2');
    }

    /**
     * @return void
     */
    public function testClear(): void
    {
        $this->localize->export();

        $this->assertLanguageFileExists('Language 1');
        $this->assertLanguageFileExists('Language 2');

        $this->localize->clear();

        $this->assertLanguageFileDoesNotExist('Language 1');
        $this->assertLanguageFileDoesNotExist('Language 2');
    }

    /**
     * @return void
     */
    public function testTrans(): void
    {
        $this->localize->export();

        $this->assertSame('', $this->localize->trans());
        $this->assertSame(null, ___());
        $this->assertSame(app(Translator::class), localize());

        App::setLocale('Language 1');
        $this->assertEquals('Value 7', $this->localize->trans('Key 2'));
        $this->assertEquals('Value 7', ___('Key 2'));
        $this->assertEquals('Value 7', localize('Key 2'));

        App::setLocale('Language 2');
        $this->assertEquals('Value 14', $this->localize->trans('Key 3'));
        $this->assertEquals('Value 14', ___('Key 3'));
        $this->assertEquals('Value 14', localize('Key 3'));
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        $this->localize->clear();

        parent::tearDown();
    }
}
