# Opnsense CAS SSO auth for captive portal

This project aims to add Cas authentication method to the core captiveportal module.
It uses a PHP enabled captive portal web server, and phpCAS client lib (https://github.com/apereo/phpCAS).

The project is in dev state, and needs many manual config on the Opnsense Console

## What's in the project ?

### `htdocs`
the cp template with phpCAs library.

### `/usr/local/etc/php.ini`
the php.ini with required extensions

### `scripts`
shell script to copy required libraries in the CP chroot

### `opnsense`
Modified files from the core captive portal.
Paths from `/usr/local/opnsenses` are included

## INSTALL
1. In Service/Captive portal, add a captive portal zone with No authentication
2. Add you CAS's server IP in allowed list
3. Copy the project in `/var/captiveportal/zone0/`
4. On opnsense console :
   
   ```shell
   # cd /var/captiveportal/zone0/scripts
   # sh copylibs.sh
   ```
   
5. Overwrite the core files of `opnsense` tree
6. Apply CP modification from ui to generate the webserver config.