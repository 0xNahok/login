# Login/Registration with database 

This is a login that saves the attempts and ip from where you tried to log in

The project is made using the following technologies:
- HTML
- CSS
- JavaScript
- PHP
- MySql

# First
Run your Apache server and MySql, import the database and then edit the following file:
> herramientas/cnx.php


Edit the parameters of the connection to the database
```
$mysqli = new mysqli("localhost", "root", "", "prueba");
```
 - First is the Hostname
 - Second is the database's username
 - Third is the password (blank if you don't have one)
 - Fourth is the name of the database
 
and Run
