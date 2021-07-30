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
        $redirects = array_intersect_key($locations, $this->config->getRedirects());

        return current($redirects) ?? null;
    }
}
