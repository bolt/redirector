<?php

declare(strict_types=1);

namespace BoltRedirector;

use Bolt\Extension\ExtensionRegistry;
use Symfony\Component\HttpFoundation\Response;

class Config
{
    /** @var */
    private $config;

    /** @var ExtensionRegistry */
    private $registry;

    /** @var Extension|null */
    private $extension;

    public function __construct(ExtensionRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function getRedirects(): array
    {
        return $this->getConfig()['redirects'] ?? [];
    }

    public function getStatusCode(): int
    {
        return $this->getConfig()['status_code'] ?? Response::HTTP_FOUND;
    }

    public function getConfig(): array
    {
        if ($this->config) {
            return $this->config;
        }

        $extension = $this->getExtension();

        if (!$extension) {
            return [];
        }

        $config = $extension->getConfig()->toArray();
        $redirects = isset($config['redirects']) ? $config['redirects'] : [];
        $statusCode = isset($config['status_code']) ? $config['status_code'] : Response::HTTP_FOUND;
        $tempConfig = [
            'redirects' => [],
            'status_code' => $statusCode,
        ];

        // Iterate over array, ensure we don't have trailing slashes (in keys and values alike)
        foreach($redirects as $from => $to) {
            $tempConfig['redirects'][rtrim($from, '/')] = rtrim($to, '/');
        }

        $this->config = array_replace_recursive($this->getDefault(), $tempConfig);

        return $this->config;
    }

    private function getExtension()
    {
        if (! $this->extension) {
            $this->extension = $this->registry->getExtension(Extension::class);
        }

        return $this->extension;
    }

    private function getDefault(): array
    {
        return [];
    }
}
