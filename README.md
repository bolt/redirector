# Bolt Redirector

Author: Ivo Valchev

This Bolt extension adds redirects from clean YAML format.

Installation:

```bash
composer require bolt/redirector
```


## Running PHPStan and Easy Codings Standard

First, make sure dependencies are installed:

```
COMPOSER_MEMORY_LIMIT=-1 composer update
```

And then run ECS:

```
vendor/bin/ecs check src
```
