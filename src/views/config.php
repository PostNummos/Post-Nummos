<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'sql150.main-hosting.eu');
define('DB_USERNAME', 'u592938272_dmeth');
define('DB_PASSWORD', '#pymxMi^5M4bAgmN');
define('DB_NAME', 'u592938272_test');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>