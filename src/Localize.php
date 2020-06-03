<?php

namespace MemoChou1993\Localize;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Symfony\Component\VarExporter\Exception\ExceptionInterface;
use Symfony\Component\VarExporter\VarExporter;

class Localize
{
    /**
     * @var array
     */
    protected array $project;

    /**
     * @var Collection|null
     */
    protected ?Collection $expectedLanguages = null;

    /**
     * @return string
     */
    protected function apiUrl(): string
    {
        return config('localize.api_url');
    }

    /**
     * @return string
     */
    protected function apiKey(): string
    {
        return config('localize.api_key');
    }

    /**
     * @return string
     */
    protected function filename(): string
    {
        return config('localize.filename');
    }

    /**
     * @return array
     */
    protected function headers(): array
    {
        return [
            'Authorization' => sprintf('Bearer %s', $this->apiKey()),
        ];
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
     * @return array
     */
    protected function getProject(): array
    {
        return $this->project ?? $this->fetchProject();
    }

    /**
     * @return Collection
     */
    protected function getKeys(): Collection
    {
        return collect($this->getProject()['keys']);
    }

    /**
     * @return Collection
     */
    public function getLanguages(): Collection
    {
        return collect($this->getProject()['languages'])->pluck('name');
    }

    /**
     * @return Collection
     */
    protected function getExpectedLanguages(): Collection
    {
        return collect($this->expectedLanguages)->whenEmpty(function () {
            return $this->getLanguages();
        });
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
     * @return array|void
     */
    protected function fetchProject()
    {
        try {
            $response = Http::retry(3, 500)
                ->baseUrl($this->apiUrl())
                ->withHeaders($this->headers())
                ->get('/api/client/project')
                ->throw();

            $data = json_decode($response->body(), true)['data'];

            $this->setProject($data);

            return $data;
        } catch (RequestException $e) {
            abort($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @param string $language
     * @return array
     */
    protected function formatKeys(string $language): array
    {
        return $this->getKeys()
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
     * @return self
     */
    public function only(...$languages): self
    {
        $this->expectedLanguages = collect($languages)
            ->flatten()
            ->intersect($this->getLanguages());

        return $this;
    }

    /**
     * @param array|string $languages
     * @return self
     */
    public function except(...$languages): self
    {
        $this->expectedLanguages = $this->getLanguages()
            ->diff(collect($languages)->flatten());

        return $this;
    }

    /**
     * @return void
     */
    public function export(): void
    {
        $this->getExpectedLanguages()
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

        $directory = lang_path($language);

        File::ensureDirectoryExists($directory);

        $filename = vsprintf('%s/%s.php', [
            $directory,
            $this->filename(),
        ]);

        file_put_contents($filename, $data);
    }

    /**
     * @return self
     */
    public function clear(): self
    {
        $directories = File::directories(lang_path());

        collect($directories)
            ->filter(function ($directory) {
                return $this->hasLanguage(basename($directory));
            })
            ->each(function ($directory) {
                File::deleteDirectory($directory);
            });

        return $this;
    }

    /**
     * @param string|null $key
     * @param int $number
     * @param array $replace
     * @param null $locale
     * @return string
     */
    public function trans($key = null, $number = 0, array $replace = [], $locale = null): string
    {
        if (is_null($key)) {
            return '';
        }

        $key = config('localize.filename').CONFIG_SEPARATOR.$key;

        return trans_choice($key, $number, $replace, $locale);
    }
}
