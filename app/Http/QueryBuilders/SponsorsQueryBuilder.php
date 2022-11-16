<?php

namespace App\Http\QueryBuilders;

use Exception;

class SponsorsQueryBuilder
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
     * Select sponsors.
     *
     * @return array
     * @throws Exception
     */
    public function selectSponsors(): array
    {
        $sql = "SELECT * FROM Sponsors";

        $result = $this->dbConnection->query($sql);

        $sponsors = [];

        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $sponsors[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'type' => $row['type'],
                'budget' => $row['budget'],
                'income' => $row['income'],
                'created' => $row['created']
            ];
        }

        if ($this->dbConnection->query($sql)) {
            return $sponsors;
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Select sponsor by id.
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function selectSponsor($id): array
    {
        $sql = "SELECT * FROM Sponsors WHERE id = {$id}";

        if ($this->dbConnection->query($sql)) {
            return $this->dbConnection->query($sql)->fetch_assoc();
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Insert new sponsor.
     *
     * @param $newSponsor
     * @return array|false|null
     * @throws Exception
     */
    public function insertSponsor($newSponsor)
    {
        [
            'name' => $name,
            'type' => $type,
            'budget' => $budget,
            'income' => $income,
            'created' => $created
        ] = $newSponsor;

        $sql = "INSERT INTO Sponsors (name, type, budget, income, created) VALUES ('$name','$type', '$budget', '$income', '$created')";

        if ($this->dbConnection->query($sql)) {
            $createdSponsorId = $this->dbConnection->insert_id;
            $createdSponsorSql = "SELECT * FROM Sponsors WHERE id = {$createdSponsorId}";

            return $this->dbConnection->query($createdSponsorSql)->fetch_assoc();
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Update sponsor.
     *
     * @param $id
     * @param $parameters
     * @return array|false|null
     * @throws Exception
     */
    public function updateSponsor($id, $parameters)
    {
        [
            'name' => $name,
            'type' => $type,
            'budget' => $budget,
            'income' => $income,
            'created' => $created
        ] = $parameters;

        $sql = "UPDATE Sponsors SET name='$name', type='$type', budget='$budget', income='$income', created='$created' WHERE id='$id'";
        $this->dbConnection->query($sql);

        if ($this->dbConnection->query($sql)) {
            $updatedSponsorSql = "SELECT * FROM Sponsors WHERE id = {$id}";

            return $this->dbConnection->query($updatedSponsorSql)->fetch_assoc();
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Delete sponsor.
     *
     * @param $id
     * @return string
     * @throws Exception
     */
    public function deleteSponsor($id)
    {
        $sql = "DELETE FROM Sponsors WHERE id = {$id}";

        $this->dbConnection->query($sql);

        if ($this->dbConnection->query($sql)) {

            return "Sponsor has been deleted.";
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }
}
