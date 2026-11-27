# Site Hardening

A WordPress plugin that sends a Content-Security-Policy and the other security headers on visitor
pages (HSTS on HTTPS), refuses XML-RPC, turns Application Passwords off, hides version comments,
WordPress's version and the PHP version, removes WordPress's emoji script, and keeps unfiltered
HTML for Administrators only. It names no site and can be used by any site that wants it.
Requires WordPress 7.0 and PHP 8.4.

## Using it in a site

A DTS site lists it in `site-packages/composer.json` at a release tag (the version without its
`v`), from this repository:

```json
{
    "repositories": [
        { "type": "vcs", "url": "https://github.com/direct-technical-solutions/dts-site-hardening" }
    ],
    "require": { "dts/site-hardening": "0.3.0" }
}
```

Composer places it in `wp-content/plugins/site-hardening/`. Its header says `Update URI: false`,
so WordPress never offers a plugin of the same name from WordPress.org as an update of this one.
Its updates reach a site only through a new tag and the site's own pin.

The policy allows only the site itself by default. The site's theme adds the outside sources its
pages need, by directive, through the filter `sitehardening_csp_sources`, for example
`array( 'frame-src' => array( 'https://www.youtube.com' ) )`; a malformed source is left out and
reported rather than sent, so the policy is then stricter, never broken or weakened.

## Working on it

The checks come from [`dts-site-tools`](https://github.com/direct-technical-solutions/dts-site-tools),
required in `composer.json`'s `require-dev`. After a fresh clone, and after each change to
`composer.lock`, the tools are installed with Composer in its pinned container:

```sh
mkdir -p vendor bin && docker run --rm -w /app -v "$PWD/composer.json:/app/composer.json:ro" -v "$PWD/composer.lock:/app/composer.lock:ro" -v "$PWD/vendor:/app/vendor" -v "$PWD/bin:/app/bin" composer:2.11.1 composer install --no-interaction --no-progress
```

`bin/plugin-check` runs every check, as the `check` workflow does on each pull request, on each
tag and weekly: the WordPress Coding Standards (`phpcs.xml.dist`, prefix `sitehardening`, text
domain `site-hardening`), PHPStan at its strictest level (`phpstan.neon.dist`), and the plugin's
file rules. The plugin's tests are kept with the tools and run in the sites that use it.

**A release:** raise the main file's `Version:`, give the version its section in `CHANGELOG.md`,
merge, then run `bin/plugin-check --tag v<version>` on the merged `main` before pushing the tag
`v<version>`. Tags are never moved or deleted. A change to the headers reaches every page of
every site that raises its pin, so each site's deploy compares its headers before and after.

## License

GPL-2.0-or-later, as WordPress. See [`LICENSE`](LICENSE).
