<?php

declare(strict_types=1);

namespace BoltRedirector;

use Bolt\Extension\ExtensionRegistry;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class Config
{
    /** @var Collection<string, int|array<string, string>>|null */
    private ?Collection $config = null;

    private ?Extension $extension = null;

    public function __construct(
        private readonly ExtensionRegistry $registry
    ) {
    }

    /**
     * @return array<string, string>
     */
    public function getRedirects(): array
    {
        /** @var array<string, string> $redirects */
        $redirects = $this->getConfig()->get('redirects', []);

        return $redirects;
    }

    public function getStatusCode(): int
    {
        /** @var int $status */
        $status = $this->getConfig()->get('status_code', Response::HTTP_FOUND);

        return $status;
    }

    /**
     * @return Collection<string, int|array<string, string>>
     */
    public function getConfig(): Collection
    {
        if ($this->config) {
            return $this->config;
        }

        $extension = $this->getExtension();

        if (! $extension) {
            return collect();
        }

        $config = $extension->getConfig()->toArray();
        $redirects = $config['redirects'] ?? [];
        $statusCode = $config['status_code'] ?? Response::HTTP_FOUND;

        $tempConfig = [
            'redirects' => [],
            'status_code' => $statusCode,
        ];

        foreach ($redirects as $from => $to) {
            $tempConfig['redirects'][rtrim((string) $from, '/')] = rtrim((string) $to, '/');
        }

        $this->config = collect(
            array_replace_recursive($this->getDefault(), $tempConfig)
        );

        return $this->config;
    }

    private function getExtension(): ?Extension
    {
        if ($this->extension) {
            return $this->extension;
        }

        $ext = $this->registry->getExtension(Extension::class);

        if (! ($ext instanceof Extension)) {
            return null;
        }

        $this->extension = $ext;

        return $this->extension;
    }

    /**
     * @return array<string, int|array<string, string>>
     */
    private function getDefault(): array
    {
        return [];
    }
}
