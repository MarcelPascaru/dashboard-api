<?php

namespace App\Http\QueryBuilders;

use Exception;

class ServicesQueryBuilder
{
    /** @var DatabaseConnection $dbConnection */
    private $dbConnection;

    /**
     * @throws Exception
     */
    public function __construct(DatabaseConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection->connection();
    }

    /**
     * Select services.
     *
     * @return array
     * @throws Exception
     */
    public function selectServices(): array
    {
        $sql = "SELECT * FROM Services";

        $result = $this->dbConnection->query($sql);

        $services = [];

        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $services[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'members' => $row['members'],
                'costs' => $row['costs'],
                'created' => $row['created']
            ];
        }

        if ($this->dbConnection->query($sql)) {
            return $services;
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Select service by id.
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function selectService($id): array
    {
        $sql = "SELECT * FROM Services WHERE id = {$id}";

        if ($this->dbConnection->query($sql)) {
            return $this->dbConnection->query($sql)->fetch_assoc();
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Insert new service.
     *
     * @param $newService
     * @return array|false|null
     * @throws Exception
     */
    public function insertService($newService)
    {
        [
            'name' => $name,
            'members' => $members,
            'costs' => $costs,
            'created' => $created
        ] = $newService;

        $sql = "INSERT INTO Services (name, members, costs, created) VALUES ('$name','$members', '$costs', '$created')";

        if ($this->dbConnection->query($sql)) {
            $createdServiceId = $this->dbConnection->insert_id;
            $createdServiceSql = "SELECT * FROM Services WHERE id = {$createdServiceId}";

            return $this->dbConnection->query($createdServiceSql)->fetch_assoc();
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Update service.
     *
     * @param $id
     * @param $parameters
     * @return array|false|null
     * @throws Exception
     */
    public function updateService($id, $parameters)
    {
        [
            'name' => $name,
            'members' => $members,
            'costs' => $costs,
            'created' => $created
        ] = $parameters;

        $sql = "UPDATE Services SET name='$name', members='$members', costs='$costs', created='$created' WHERE id='$id'";
        $this->dbConnection->query($sql);

        if ($this->dbConnection->query($sql)) {
            $updatedServiceSql = "SELECT * FROM Services WHERE id = {$id}";

            return $this->dbConnection->query($updatedServiceSql)->fetch_assoc();
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Delete service.
     *
     * @param $id
     * @return string
     * @throws Exception
     */
    public function deleteService($id)
    {
        $sql = "DELETE FROM Services WHERE id = {$id}";

        $this->dbConnection->query($sql);

        if ($this->dbConnection->query($sql)) {

            return "Service has been deleted.";
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }
}
