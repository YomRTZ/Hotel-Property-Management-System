<?php
require_once 'D:/xampp/htdocs/frontoffice/vendor/autoload.php';
use RedBeanPHP\R;
$host = 'localhost';
$dbname = 'FrontOffice';
$username = 'root'; 
$password = '';    


R::setup("mysql:host=$host;dbname=$dbname", $username, $password);

if (!R::testConnection()) {
    die("Database connection failed. Please check your settings.");
}


R::freeze(true);
?>