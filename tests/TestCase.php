<?php

namespace MemoChou1993\Localize\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Http;
use MemoChou1993\Localize\Facades\Localize;
use MemoChou1993\Localize\LocalizeServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * @param  Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LocalizeServiceProvider::class,
        ];
    }

    /**
     * @param  Application  $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'localize' => Localize::class,
        ];
    }

    /**
     * @param string $filename
     * @return void
     */
    protected function request(string $filename): void
    {
        Http::fake(function () use ($filename) {
            $data = file_get_contents(__DIR__.'/data/'.$filename.'.json');

            $body = json_decode($data, true);

            return Http::response($body);
        });
    }
}
