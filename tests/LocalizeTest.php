<?php

namespace MemoChou1993\Localize\Tests;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Translation\Translator;
use MemoChou1993\Localize\Client;
use MemoChou1993\Localize\Localize;
use Mockery\MockInterface;

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

        $this->mock(Client::class, function ($mock) {
            /** @var MockInterface $mock */
            $mock
                ->shouldReceive('fetchProject')
                ->once()
                ->andReturn(
                    new Response(200, [], file_get_contents(__DIR__.'/data/project.json'))
                );
        });

        $this->localize = app(Localize::class);
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
    public function testHasLanguage(): void
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

        $this->assertLanguageDirectoryDoesNotExist('Language 1');
        $this->assertLanguageDirectoryDoesNotExist('Language 2');
    }

    /**
     * @return void
     */
    public function testDefaultFileExists(): void
    {
        File::ensureDirectoryExists(lang_path('Language 1'));

        File::put(lang_path('Language 1/default.php'), null);

        $this->localize->clear();

        $this->assertFileExists(lang_path('Language 1/default.php'));
    }

    /**
     * @return void
     */
    public function testDefaultDirectoryExists(): void
    {
        File::ensureDirectoryExists(lang_path('zh-TW'));

        $this->localize->clear();

        $this->assertDirectoryExists(lang_path('zh-TW'));
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
}
