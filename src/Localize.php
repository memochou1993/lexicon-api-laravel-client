<?php

namespace MemoChou\Localize;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Symfony\Component\VarExporter\Exception\ExceptionInterface;
use Symfony\Component\VarExporter\VarExporter;

class Localize extends Client
{
    /**
     * @var array
     */
    protected $project;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        try {
            $this->fetch();
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param array $project
     * @return void
     */
    protected function setProject($project): void
    {
        $this->project = $project;
    }

    /**
     * @return Collection
     */
    protected function getRawKeys(): Collection
    {
        return collect($this->project['keys']);
    }

    /**
     * @return Collection
     */
    protected function getRawLanguages(): Collection
    {
        return collect($this->project['languages']);
    }

    /**
     * @return Collection
     */
    public function getLanguages(): Collection
    {
        return $this->getRawLanguages()->pluck('name');
    }

    /**
     * @param mixed $language
     * @return bool
     */
    public function hasLanguage($language): bool
    {
        return $this->getLanguages()->contains($language);
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function fetch(): void
    {
        $uri = 'api/client/projects/'.$this->getProjectId();

        try {
            $response = $this->getClient()->get($uri, [
                'headers' => $this->getHeaders(),
            ]);
        } catch (ClientException $e) {
            $this->exception = $e;

            $message = vsprintf('%s %s', [
                $e->getResponse()->getStatusCode(),
                $e->getResponse()->getReasonPhrase()
            ]);

            throw new Exception($message);
        }

        $data = json_decode($response->getBody(), true);

        $this->setProject($data['data']);
    }

    /**
     * @param string $language
     * @return array
     */
    protected function formatKeys(string $language): array
    {
        return $this->getRawKeys()
            ->mapWithKeys(function ($key) use ($language) {
                return [
                    $key['name'] => $this->formatValues($key['values'], $language),
                ];
            })
            ->toArray();
    }

    /**
     * @param array $values
     * @param string $language
     * @return string
     */
    protected function formatValues(array $values, string $language): string
    {
        return collect($values)
            ->filter(function ($value) use ($language) {
                return $value['language']['name'] === $language;
            })
            ->map(function ($value) {
                return vsprintf('%s%s%s%s%s%s', [
                    '[',
                    $value['form']['range_min'],
                    ',',
                    $value['form']['range_max'],
                    ']',
                    $value['text'],
                ]);
            })
            ->implode('|');
    }

    /**
     * @param array|string $languages
     * @return void
     */
    public function export(...$languages): void
    {
        collect($languages)
            ->flatten()
            ->each(function ($language) {
                if (! $this->hasLanguage($language)) {
                    return;
                }

                $this->save($language);
            });
    }

    /**
     * @return void
     */
    public function exportAll(): void
    {
        $this->getLanguages()
            ->each(function ($language) {
                $this->save($language);
            });
    }

    /**
     * @param string $language
     * @return void
     * @throws ExceptionInterface
     */
    protected function save(string $language): void
    {
        $keys = $this->formatKeys($language);

        $data = vsprintf('%s%s%s%s%s%s%s', [
            '<?php',
            PHP_EOL,
            PHP_EOL,
            'return ',
            VarExporter::export($keys),
            ';',
            PHP_EOL,
        ]);

        $directory = vsprintf('%s/%s', [
            $this->getDirectory(),
            $language,
        ]);

        File::ensureDirectoryExists($directory);

        $filename = vsprintf('%s/%s.php', [
            $directory,
            $this->getFilename(),
        ]);

        file_put_contents($filename, $data);
    }
}
