<?php
declare(strict_types = 1);

namespace App\classes;

use Exception;
use PDO;

class DbUtils {
    /**
     * This function creates a new instance of the mysql connector
     * @return PDO returns the PDO object
     */
    static function initialize(): PDO {
        return new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";
                           dbname=" . $_ENV['DB_NAME'] . ";
                           charset=utf8", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
    }

	/**
	 * This function makes an insertion into the database
	 * @param DbTable $table the table that will receive the insertion
	 * @param array $columns array of columns that will be affected by the insertion
	 * @param array $values array of values that will be inserted into the columns
	 * @param string $extra adds SQL code to the query
	 * @return bool returns true is the operation succeed, false if it failed
	 * @throws Exception
	 */
    public static function insert(DbTable $table, array $columns = [], array $values = [], string $extra = ""): bool
    {
		if (count($columns) == count($values)) {
			$table = $table->value;
			$implodedColumns = implode(", ", $columns);
			$dynamicValues = "";

			for ($i = 1; $i <= count($values); $i++) {
				$dynamicValues .= count($values) == $i ? "?" : "?, ";
			}

			$queryExtra = !empty($condition) ? " $extra" : "";
			$queryBuilder = "INSERT INTO $table($implodedColumns) VALUES($dynamicValues)$queryExtra;";
			$query = self::initialize()->prepare($queryBuilder);

			return $query->execute($values);
		} else {
			throw new Exception("The columns and the values aren't the same size");
		}
    }
}
