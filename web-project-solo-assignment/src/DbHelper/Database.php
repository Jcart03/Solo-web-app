<?php


namespace P2718293\SoloWebDev2025\DbHelper;

use PDO;
use PDOException;
/**
 * Database
 *
 * Helper class for centralising database connection logic multiple connections = BAD
 */

 class Database {
    private static ?PDO $pdo = null;

    public static function connect(): PDO {
        if(self::$pdo === null) {
            try {
                $rootPath = dirname(__DIR__, 2);
                
                self::$pdo = new PDO('sqlite:'.$rootPath.'/data/Web_app.sqli');
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die("Database Connection Failed. ". $e->getMessage());
            }
        }
        return self::$pdo;
    }
 }