# Changelog

What changed in each release, for the sites that use the plugin. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/); versions follow
[Semantic Versioning](https://semver.org/).

## [Unreleased]

## [0.4.0] - 2026-11-27

### Added

- WordPress's emoji support removed (`includes/emoji.php`): the detection script and its styles
  on visitor pages, in the admin and in embeds, and the swap of emoji for pictures from
  WordPress.org's servers in feeds and email. The plugin's own Content-Security-Policy refuses
  the detection script, and the pictures would send visitors' addresses to WordPress.org. A site
  whose theme removed emoji support itself can drop that code; doing it twice is harmless.

## [0.3.0] - 2026-11-26

### Added

- The plugin's first release from its own repository, the same code a DTS site has run as one of
  its own plugins: the Content-Security-Policy and the other security headers on visitor pages,
  XML-RPC refused, Application Passwords off, version details hidden, and unfiltered HTML for
  Administrators only.
