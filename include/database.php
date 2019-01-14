<?php

class Database {

    public static $conn = null;

    public $authorFilter;

    public $statusFilter;


    public static function getActiveConnection() {
        if (is_null(self::$conn)) {
            die('Failed to retrieve active connection');
        }

        return self::$conn;
    }

    public static function connect($type ='', $host = '', $port = '', $username = '', $password = '', $db ='') {
        $dsn = sprintf('%s:host=%s;port=%s;dbname=%s', $type, $host, $port, $db);

        try {
            self::$conn = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            die("Connection Failed: " . $e->getMessage());
        }
    }

    public static function exec($sql, $params = []) {
        $statement = self::getActiveConnection()->prepare($sql);

        $statement->execute($params);

        return $statement;
    }

    public function getRows($sql, $params = []) {
        return $this->exec($sql, $params)->fetchAll();
    }

    public function getRow($sql, $params = []) {
        $results = $this->getRows($sql, $params);
        return empty($results) ? [] : $results[0];
    }

    public function getCountColumn($sql, $params = []) {
        $results = $this->getRow($sql, $params);
        return empty($results) ? 0 : intval($results['total']);
    }
}
