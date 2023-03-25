<?php

class DBUtils {
    const DB_HOST = "database";
    const DB_NAME = "rotr";
    const DB_USERNAME = "root";
    const DB_PASSWORD = "ChangeMe";

    /**
     * This function creates a new instance of the mysql connector
     * @return PDO returns the PDO object
     */
    static function initialize(): PDO {
        return new PDO("mysql:host=" . self::DB_HOST . ";
                           dbname=" . self::DB_NAME . ";
                           charset=utf8", self::DB_USERNAME, self::DB_PASSWORD);
    }

    /**
     * This function makes an insertion into the database
     * @param string $table the table that will receive the insertion
     * @param array $columns array of columns that will be affected by the insertion
     * @param array $values array of values that will be inserted into the columns
     * @return bool returns true is the operation succeed, false if it failed
     */
    public static function insert(string $table = "", array $columns = [], array $values = []): bool
    {
        $query = self::initialize()->prepare("INSERT INTO player(username, password, email, score, level, coins) 
                                                    VALUES(?, ?, ?, ?, ?, ?)");
        $query->execute(array("test", "test123!", "test@test.dev", 2300, 2, 50));

        return true;
    }

}
