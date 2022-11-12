<?php

namespace App\Http\QueryBuilders;

use Exception;

class EmployeeQueryBuilder
{
    /** @var DatabaseConnection $dbConnection */
    private $dbConnection;

    public function __construct(DatabaseConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection->connection();
    }

    /**
     * Select employees.
     *
     * @return array
     * @throws Exception
     */
    public function selectEmployees(): array
    {
        $sql = "SELECT * FROM Employees";

        $result = $this->dbConnection->query($sql);

        $employees = [];

        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $employees[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'age' => $row['age'],
                'designation' => $row['designation'],
                'created' => $row['created']
            ];
        }

        if ($this->dbConnection->query($sql)) {
            return $employees;
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Select employee by id.
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function selectEmployee($id): array
    {
        $sql = "SELECT * FROM Employees WHERE id = {$id}";

        if ($this->dbConnection->query($sql)) {
            return $this->dbConnection->query($sql)->fetch_assoc();
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Insert new employee.
     *
     * @param $newEmployee
     * @return array|false|null
     * @throws Exception
     */
    public function insertEmployee($newEmployee)
    {
        [
            'name' => $name,
            'age' => $age,
            'designation' => $designation,
            'created' => $created
        ] = $newEmployee;

        $sql = "INSERT INTO Employees (name, age, designation, created) VALUES ('$name', '$age', '$designation', '$created')";

        if ($this->dbConnection->query($sql)) {
            $createdEmployeeId = $this->dbConnection->insert_id;
            $createdEmployeeSql = "SELECT * FROM Employees WHERE id = {$createdEmployeeId}";

            return $this->dbConnection->query($createdEmployeeSql)->fetch_assoc();
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Update employee.
     *
     * @param $id
     * @param $parameters
     * @return array|false|null
     * @throws Exception
     */
    public function updateEmployee($id, $parameters)
    {
        [
            'name' => $name,
            'age' => $age,
            'designation' => $designation,
            'created' => $created
        ] = $parameters;

        $sql = "UPDATE Employees SET name='$name', age='$age', designation='$designation', created='$created' WHERE id='$id'";
        $this->dbConnection->query($sql);

        if ($this->dbConnection->query($sql)) {
            $updatedEmployeeSql = "SELECT * FROM Employees WHERE id = {$id}";

            return $this->dbConnection->query($updatedEmployeeSql)->fetch_assoc();
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Delete employee.
     *
     * @param $id
     * @return string
     * @throws Exception
     */
    public function deleteEmployee($id)
    {
        $sql = "DELETE FROM Employees WHERE id = {$id}";

        $this->dbConnection->query($sql);

        if ($this->dbConnection->query($sql)) {

            return "Employee has been deleted.";
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }
}
