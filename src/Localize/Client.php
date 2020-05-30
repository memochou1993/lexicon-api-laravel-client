<?php

namespace Memochou1993\Localize;

use Exception;
use GuzzleHttp\Client as GuzzleClient;

class Client
{
    /**
     * @var GuzzleClient
     */
    protected $client;

    /**
     * @var Exception
     */
    protected $exception;

    /**
     * @return string
     */
    public function getHost(): string
    {
        return config('localize.host');
    }

    /**
     * @return string
     */
    public function getProjectId(): string
    {
        return config('localize.project_id');
    }

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return config('localize.secret_key');
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return config('localize.filename');
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return [
            'X-Localize-Secret-Key' => $this->getSecretKey(),
        ];
    }

    /**
     * @return GuzzleClient
     */
    public function getClient(): GuzzleClient
    {
        return $this->client ?? $this->createClient();
    }

    /**
     * @return GuzzleClient
     */
    public function createClient(): GuzzleClient
    {
        $this->client = new GuzzleClient([
            'base_uri' => $this->getHost(),
        ]);

        return $this->client;
    }

    /**
     * @return exception
     */
    public function getException(): exception
    {
        return $this->exception;
    }
}
