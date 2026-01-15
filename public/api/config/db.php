<?php

class Database {
    private static $connection = null;

    private function __construct() {}

    public static function getConnection() {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=127.127.126.5;dbname=php-test;charset=utf8mb4",
                    "root",
                    ""
                );

                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Dab conn err'
                ]);
                exit;
            }
        }

        return self::$connection;
    }
}
