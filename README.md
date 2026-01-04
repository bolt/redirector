# Bolt Redirector

Author: Ivo Valchev

Bolt Redirector is a Bolt CMS extension that performs simple URL redirects defined in a clean YAML config file.

## Features

- Define redirects in YAML (`from` → `to`).
- Match redirects by either absolute path (`/old-page`) or full URL (`https://example.org/old-page`).
- Configurable HTTP status code (default **302** / “Found”).
- Avoids redirecting Bolt backend and async/admin requests.

## Compatibility

This extension supports different Bolt CMS versions depending on the major release:

- **Bolt CMS 6** → Bolt Redirector extension **v2.x**
- **Bolt CMS 5** → Bolt Redirector extension **v1.x**

This README documents usage for **Bolt CMS 6**.

## Installation:

```bash
composer require bolt/redirector
```


## Configuration
After installation, configure the extension using its config file (typically located under your project’s Bolt extensions config directory, depending on how your Bolt project is set up).

The extension ships with a `config.yaml` template that documents these options.

Example `config.yaml`

```yaml
# Redirector extension configuration file

# Optional: status code for redirects
# Common values:
#  - 301 (permanent)
#  - 302 (temporary, default)
status_code: 301

redirects:
  # You can use an absolute path:
  /page/about: /page/about-us

  # You can also match a full URI (quote it because of ":" in "https://"):
  "https://example.org/page/mission": "/page/our-mission"

  # Trailing slashes are normalized, so these are treated the same:
  /blog: /news
  /blog/: /news/
```

## Running Rector, PHPStan and Easy Codings Standard

First, make sure dependencies are installed:

```
COMPOSER_MEMORY_LIMIT=-1 composer update
```

And then run code quality checks:
- `vendor/bin/rector process -n --no-progress-bar --ansi`
- `vendor/bin/phpstan analyse --ansi`
- `vendor/bin/ecs check src --ansi`

