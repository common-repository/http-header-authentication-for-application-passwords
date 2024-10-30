# HTTP Header Authentication for Application Passwords

Contributors: cameronjonesweb
Donate link: https://www.patreon.com/cameronjonesweb
Requires at least: 5.6.1
Tested up to: 5.8
Requires PHP: 5.6
Stable tag: 1.0.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows sending application passwords using HTTP headers instead of basic authentication
 
## Description

Use HTTP headers for application passwords instead of basic authentication. Perfect for those sites already protected by basic auth.

Username header: `X-WP-USERNAME`
Password header: `X-WP-PASSWORD`

Note that at this point the plugin doesn't actually remove the basic authentication validation for application passwords, but checks the HTTP headers at a higher priority.

## Changelog

### 1.0.1
* Add bypass for `wp_is_site_protected_by_basic_auth` to allow users to generate passwords on sites already behind basic auth

### 1.0.0
* Initial release
 
