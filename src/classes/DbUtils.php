<?php
declare(strict_types = 1);

namespace App\classes;

use Exception;
use PDO;
use PDOStatement;

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
	 * This method makes an insertion into the database
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

			$queryExtra = !empty($extra) ? " $extra" : "";
			$queryBuilder = "INSERT INTO $table($implodedColumns) VALUES($dynamicValues)$queryExtra;";
			$query = self::initialize()->prepare($queryBuilder);

			return $query->execute($values);
		} else {
			throw new Exception("The columns and the values aren't the same size");
		}
    }

	/**
	 * This method makes a simple deletion of a row in the database
	 * @param DbTable $table the table that will receive the deletion
	 * @param int $id the id of the element that will be deleted
	 * @return bool returns true is the operation succeed, false if it failed
	 * @throws Exception
	 */
	public static function delete(DbTable $table, int $id): bool
	{
		if ($id) {
			$table = $table->value;
			$queryBuilder = "DELETE FROM $table WHERE id = $id;";
			$query = self::initialize()->prepare($queryBuilder);

			return $query->execute();
		} else {
			throw new Exception("The id must not be empty");
		}
	}

	/**
	 * This method makes a simple select query into to the database
	 * @param DbTable $table the table that will receive the insertion
	 * @param array $columns array of columns that will be selected
	 * @param string $condition adds SQL condition to the selection query
	 * @return false|PDOStatement returns the PDO statement of the query if it succeeds, false if the query failed
	 * @throws Exception
	 */
	public static function select(DbTable $table, array $columns = ["*"], string $condition = ""): false|PDOStatement
	{
		if (count($columns) > 0) {
			$table = $table->value;
			$implodedColumns = implode(", ", $columns);
			$queryCondition = !empty($condition) ? " $condition" : "";
			$queryBuilder = "SELECT $implodedColumns FROM $table$queryCondition;";

			return self::initialize()->query($queryBuilder);
		} else {
			throw new Exception("At least one column is required to make a selection");
		}
	}

    /**
     * This method makes a simple update query into the database
     * @param DbTable $table the table that will receive the update
     * @param string $column the column that wll receive the update
     * @param mixed $value the value that will replace the previous one
     * @param string $condition adds SQL condition to the selection query
     * @return bool|PDOStatement returns true is the operation succeed, false if it failed
     * @throws Exception
     */
    public static function update(DbTable $table, string $column, mixed $value, string $condition = ""): bool|PDOStatement
    {
        if (!empty($column)) {
            $table = $table->value;
            $queryCondition = !empty($condition) ? " $condition" : "";
            $queryBuilder = "UPDATE $table SET $column = '$value'$queryCondition;";
            $query = self::initialize()->query($queryBuilder);

            return $query->execute();
        } else {
            throw new Exception("A column is required to update a table");
        }
    }

    /**
     * This method checks if a value already exists in a specified column
     * @param DbTable $table the table that will be checked
     * @param string $column the column that will be checked
     * @param string $value the value that will be checked
     * @return bool returns true if the value already exists, false if it doesn't
     * @throws Exception
     */
    public static function doesThisValueExist(DbTable $table, string $column, string $value): bool {
        if (!empty($column)) {
            $table = $table->value;
            $queryBuilder = "SELECT $column FROM $table WHERE $column = '$value';";

            return !(self::initialize()->query($queryBuilder)->rowCount() > 0);
        } else {
            throw new Exception("The column can't be empty");
        }
    }
}
