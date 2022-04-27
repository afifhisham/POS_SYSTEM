# Project title: POS Web SQL


### Introduction

This project is aiming to create a database in Web SQL for POS System. It is including the tables creation, data insertion, and retrieve the value from tables stored in Web SQL. In this project, the data that have been inserted into tables in Web SQL is the exported data from SQL file of the database in PhpMyAdmin. Another purpose of this project is to compare the last entered data into table based on the datetime in Web SQL. 

### Installation
To access this project, the software programs need to be installed:
* XAMPP Installer
* Any IDE; in this project, Microsoft Visual Studio Code or PhpStorm is used.

Fistly, you need to create the database and tables in PhpMyAdmin, then insert the data into the tables. Below is the steps to create the database in PHPMyAdmin:

1. Open PHPMyAdmin (http://localhost/phpmyadmin)
2. ```Create a database with name kedairuncitsl```
     ![](gitImg/createDB.png)
     
3. Create tables with table name **category**, **supplier**, and **item**.
     * Table: category
     
     ![](gitImg/2022-04-27%20(7).png)
     
     * Table: supplier
     
     ![](gitImg/2022-04-27%20(8).png)
     
     * Table: item
     
     ![](gitImg/2022-04-27%20(4).png)
     

### Example/ Tutorial
* Create a PHP file named connection.php. This file use to connect the database.

```php
<?php
define("HOST", "localhost");     // The host you want to connect to.
define("USER", "root");    // The database username.
define("PASSWORD","");    // The database password.
define("DATABASE", "kedairuncitsl");    // The database name.
define("PASSWORD_KEY", "SMARTLAB");
define("QUOTES_GPC", (ini_get('magic_quotes_gpc') ? TRUE : FALSE));
date_default_timezone_set('Asia/Kuala_Lumpur');

try {
    $dbx = new PDO('mysql:host='.HOST.';dbname='.DATABASE, USER, PASSWORD);
    $dbx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbx->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
```

### Issue tracker for others
     https://github.com/nurulshafiqa/POS_SYSTEM/issues
     
### API documentation
1) Function errorHandler
  ```javascript
  function errorHandler(transaction, error) {
     //some lines of codes
           }
  ```
  
* What a function do
     - This function is used to write out any errors and it will console the error message.
     
* What the function's parameters or arguments are
     - **transaction** and **error** are the parameters for this function.
     
* What a function returns
     - This function will return boolean true if there's an error.


2) Function runExample()

```javascript
function runExample() {
    //some lines of codes
     }
```
* What a function do
     - This function is used to call another functions
     
* What the function's parameters or arguments are
     - This function has no parameter
     
* What a function returns
     - This function has no return value.
 
 
3. Function createDbAndTables(callback)

```javascript
function createDbAndTables(callback) {
       //some lines of codes
}// end createDB fx
```
* What a function do
     - This function is used to create tables which is table category, supplier, and item in Web SQL. It is also used to insert data into those tables.
     
* What the function's parameters or arguments are
     - This function has callback as the parameter (function that is passed as an argument to another function, to be “called back” at a later time.)
     
* What a function returns
     - This function has no return value.
 
 4. Function getAllTablesFromDB()
 ```javascript
  function getAllTablesFromDB(callback) {
            //some lines of codes
        }
 ```
* What a function do
     - This function is used to select tables name from built-in Web SQL table which is **sqlite_master** table and call another function to display all data inserted into the table in HTML table
     
* What the function's parameters or arguments are
     - This function has callback as the parameter (function that is passed as an argument to another function, to be “called back” at a later time.)
     
* What a function returns
     - This function has no return value.
