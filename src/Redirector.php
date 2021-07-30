<?php

namespace BoltRedirector;

class Redirector
{
    /** @var Config */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function findFor(array $locations): ?string
    {
        $redirects = $this->config->getRedirects();
        $redirectKey = current(array_intersect($locations, array_keys($redirects)));

        if ($redirectKey) {
            return $this->config->getRedirects()[$redirectKey];
        }

        return null;
    }
}
