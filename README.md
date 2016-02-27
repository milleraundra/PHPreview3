# Count Repeats

#### _This app allows the manager of a hair salon to view all of his stylists and their individual clients._

#### By Aundra Miller

## Description

This application allows a hair salon to track their stylists and their individual clients. Clients can be added, edited, and deleted from stylists, and stylist information can be updated or deleted as needed.
The application was developed using PHP, MySQL, Silex, Twig, and PHPUnit.

## Setup/Installation Requirements

To work properly, this application requires:

* Composer.
* Twig and Silex installation.
* Local server.
* MySQL database.

Setup instructions:

1. Clone this repository.

2. Go to the root directory.

3. Run 'composer install' in the terminal (to install Twig and Silex).

4. Start the MySQL server:
  * Enter 'apachectl start' in the terminal.
  * Navigate to 'localhost:8080/phpmyadmin'.

5. Upload MySQL database:
  * Log in to your account on PHPMyAdmin.
  * Select the 'Import' tab.
  * Choose the .mysql database file in the project folder.
  * Click 'Go'.

6. Start your local server.
  * Navigate in the terminal to the web folder in the main project folder.
  * Enter 'php -S localhost:8000' in the terminal.
  * Enter 'localhost:8000' into your browser.

## Known Bugs

CSS styles to not display consistently. Probably a routing problem.

## Support and contact details

If you have any questions, concerns, or suggestions, contact me directly at miller.aundra@gmail.com. Pull requests can be submitted directly to milleraundra on Github.

## Technologies Used

* PHP
* MySQL
* HTML
* Twig
* Silex
* PHPUnit
* CSS
* Bootstrap

### License

The MIT License (MIT)

Copyright (c) 2016 Aundra Miller

### MySQL Command Line History
mysql> SHOW DATABASES
    -> ;
+--------------------+
| Database           |
+--------------------+
| information_schema |
| cuisine            |
| cuisine_test       |
| mysql              |
| performance_schema |
| sys                |
+--------------------+
6 rows in set (0.00 sec)

mysql> DELETE FROM cuisine_test
    -> ;
ERROR 1046 (3D000): No database selected
mysql> DELETE cuisine_test
    -> ;
ERROR 1064 (42000): You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1
mysql> DROP DATABASE cuisine_test;
Query OK, 2 rows affected (0.03 sec)

mysql> SHOW DATABASES;
+--------------------+
| Database           |
+--------------------+
| information_schema |
| cuisine            |
| mysql              |
| performance_schema |
| sys                |
+--------------------+
5 rows in set (0.00 sec)

mysql> DROP DATABASE cuisine;
Query OK, 2 rows affected (0.01 sec)

mysql> CREATE DATABASE hair_salon;
Query OK, 1 row affected (0.00 sec)

mysql> USE hair_salon;
Database changed
mysql> CREATE TABLE stylists(id serial PRIMARY KEY, name VARCHAR(255), services VARCHAR(255), phone INT);
Query OK, 0 rows affected (0.06 sec)

mysql> ALTER TABLE stylists DROP phone;
Query OK, 0 rows affected (0.07 sec)
Records: 0  Duplicates: 0  Warnings: 0

mysql> ALTER TABLE stylist ADD phone VARCHAR(20);
ERROR 1146 (42S02): Table 'hair_salon.stylist' doesn't exist
mysql> ALTER TABLE stylists ADD phone VARCHAR(20);
Query OK, 0 rows affected (0.08 sec)
Records: 0  Duplicates: 0  Warnings: 0

mysql> DESCRIBE stylists;
+----------+---------------------+------+-----+---------+----------------+
| Field    | Type                | Null | Key | Default | Extra          |
+----------+---------------------+------+-----+---------+----------------+
| id       | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| name     | varchar(255)        | YES  |     | NULL    |                |
| services | varchar(255)        | YES  |     | NULL    |                |
| phone    | varchar(20)         | YES  |     | NULL    |                |
+----------+---------------------+------+-----+---------+----------------+
4 rows in set (0.00 sec)

mysql> ALTER TABLE stylists DROP phone;
Query OK, 0 rows affected (0.11 sec)
Records: 0  Duplicates: 0  Warnings: 0

mysql> ALTER TABLE stylists ADD phone INT;
Query OK, 0 rows affected (0.10 sec)
Records: 0  Duplicates: 0  Warnings: 0

mysql> DESCRIBE stylists;
+----------+---------------------+------+-----+---------+----------------+
| Field    | Type                | Null | Key | Default | Extra          |
+----------+---------------------+------+-----+---------+----------------+
| id       | bigint(20) unsigned | NO   | PRI | NULL    | auto_increment |
| name     | varchar(255)        | YES  |     | NULL    |                |
| services | varchar(255)        | YES  |     | NULL    |                |
| phone    | int(11)             | YES  |     | NULL    |                |
+----------+---------------------+------+-----+---------+----------------+
4 rows in set (0.00 sec)

mysql> ALTER TABLE stylists DROP phone;
Query OK, 0 rows affected (0.10 sec)
Records: 0  Duplicates: 0  Warnings: 0

mysql> ALTER TABLE stylists ADD phone VARCHAR(20);
Query OK, 0 rows affected (0.10 sec)
Records: 0  Duplicates: 0  Warnings: 0

mysql> CREATE TABLE clients(id serial PRIMARY KEY, name VARCHAR(255), phone VARCHAR(20), stylist_id TINYINT);
Query OK, 0 rows affected (0.07 sec)

mysql> ALTER TABLE clients DROP stylist_id;
Query OK, 0 rows affected (0.07 sec)
Records: 0  Duplicates: 0  Warnings: 0

mysql> ALTER TABLE clients ADD stylist_id INT;
Query OK, 0 rows affected (0.08 sec)
Records: 0  Duplicates: 0  Warnings: 0
