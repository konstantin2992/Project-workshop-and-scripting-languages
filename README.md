To work with this web-platform you need to install packeges: php, mariadb (other sql).

First:
Go to sql directory and run command to set up database: sudo mariadb -u root healthsync < database.sql

To start site you need in root folder write: php -S localhost:3000, and go to this link in browser: http://localhost:3000/modules/register-form/controllers/login.php, as a start page.
