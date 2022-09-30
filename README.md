# Health Certificate Management System

Local web application for Laoag's City Health Office. Includes record management and printing of Health Certificates, Sanitary Permits, and Pink Health Certificates. Written in PHP and utilizes the Laravel framework.

## Software prerequisites

 - XAMPP (PHP 7.4, MariaDB 10.4). Download [here](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.4.29/xampp-windows-x64-7.4.29-1-VC15-installer.exe/download).
 - NodeJS 10 or higher, preferably (developed and tested using NodeJS 15.6). Download [here](https://nodejs.org/en/). NodeJS is needed for package managing and compiling front-end dependencies during development. 
 - [PHP Composer](https://getcomposer.org/download/). PHP Composer is needed for managing PHP package dependencies.

## Server Installation

 1. Install all software prerequisites. Use default installation options.
 
 2. Download .zip file of [HCMS](https://github.com/Laoag-City/hcms) and extract it at `C:/xampp/htdocs` folder.
 
 3. Add the following entry in XAMPP's virtual host in `C:/xampp/apache/conf/extra/httpd-vhosts.conf`:
	 ```
	 <VirtualHost *:443>
	    DocumentRoot "C:/xampp/htdocs/hcms/public"
	    ServerName hcms.local
	    SSLEngine On
	    SSLCertificateFile "C:/xampp/apache/conf/ssl.crt/server.crt"
	    SSLCertificateKeyFile "C:/xampp/apache/conf/ssl.key/server.key"
	</VirtualHost>
	```
 
 4. Open XAMPP Control Panel as an Administrator and check the Service checkbox of Apache and MySQL to install them as Windows services.
 
 5. Add the following host mapping of HCMS at `C:/Windows/System32/drivers/etc/hosts`:
	 ```
	 127.0.0.1	hcms.local
	 ```
 
 6. Access `localhost/phpmyadmin/`, create a new database named `hcms_db` with collation of `utf8mb4_unicode_ci`.
 
 7. At `C:/xampp/htdocs/hcms`, duplicate `.env.example`, remove its `.example` suffix, and change the following name/value entries into these:
	 ```
	APP_NAME="Health Certificate Management System"
	DB_DATABASE=hcms_db
	DB_USERNAME=root
	DB_PASSWORD=
	 ```
 
 8. Open your terminal and enter the following commands to initialize app key, database migrations and seeds:
	 ```
	 cd c:/xampp/htdocs/hcms
	 php artisan key:generate
	 php artisan migrate
	 php artisan migrate --path=database/migrations/pink_card_related_tables_and_rows_and_permit_updates
	 php artisan db:seed
	 ```

9. Install the dependencies by running the following commands:
	 ```
	composer install
	npm install
	 ``` 

10. Follow [these](https://gist.github.com/Splode/94bfa9071625e38f7fd76ae210520d94) steps to register the scheduled tasks of the application into the operating system.

11. The application is now set. Access it at `https://hcms.local/`. Disregard the web browser's SSL Certificate validation if it blocks your access and proceed regardless of the security notice.

## Client Installation
Before connecting clients to the server, it is recommended to set the server's IP address statically in the DHCP server to ensure a uniform address that the client computers will access to. This guide assumes the IP address scheme `192.168.2.x` and subnet mask `255.255.255.240` in the network, with the server having an IP address of `192.168.2.1`, and client computers having the IP address of `192.168.2.2` and beyond. This network setup is currently being used at the City Health Office.

 1. Add the following host mapping of the HCMS server at `C:/Windows/System32/drivers/etc/hosts`:
	 ```
	 192.168.2.1	hcms.local
	 ```

2. The application is now set. Access it at `https://hcms.local/`. Disregard the web browser's SSL Certificate validation if it blocks your access and proceed regardless of the security notice.

## User accounts
To add user accounts, log in the admin account. Username: *administrator*. Password: *city_health_admin*. Navigate to User Administration at the menu to add new users.
