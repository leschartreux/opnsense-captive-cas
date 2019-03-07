# Opnsense CAS SSO auth for captive portal

This project aims to add Cas authentication method to the core captiveportal module.
It uses a PHP enabled captive portal web server, and phpCAS client lib (https://github.com/apereo/phpCAS).

The project is in dev state, and needs many manual config on the pfsense

## What's in the project ?

### `htdocs`
the cp template with phpCAs library.

### `/usr/local/etc/php.ini`
the php.ini with required extensions

### `scripts`
shell script to copy required libraries in the CP chroot

### `opnsense`
Modified files from the core project.
paths from `/usr/local/opnsenses` are included

## INSTALL
1. Add a captive portal zone with No authentication
2. copy the project in /var/captiveportal/zone0/
3. launch `sh scripts/copylibs.sh`
4. overwrite the core files of `opnsense` tree