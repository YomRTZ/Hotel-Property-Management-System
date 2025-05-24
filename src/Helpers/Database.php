<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use RedBeanPHP\R as R;
use Dotenv\Dotenv;

class Database {
    public function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        R::setup(
            'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASS']
        );

        // Freeze schema in production to prevent automatic changes
        // R::freeze(true);
    }

    public function __destruct() {
        R::close();
    }
}