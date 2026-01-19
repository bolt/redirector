<?php

declare(strict_types=1);

namespace BoltRedirector;

class Redirector
{
    public function __construct(
        private readonly Config $config
    ) {
    }

    /**
     * @param string[] $locations
     */
    public function findFor(array $locations): ?string
    {
        $redirects = $this->config->getRedirects();
        $redirectKey = current(array_intersect($locations, array_keys($redirects)));

        if ($redirectKey) {
            return $redirects[$redirectKey];
        }

        return null;
    }

    public function getStatusCode(): int
    {
        return $this->config->getStatusCode();
    }
}
