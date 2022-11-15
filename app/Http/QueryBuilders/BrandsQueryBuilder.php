<?php

namespace App\Http\QueryBuilders;

use Exception;

class BrandsQueryBuilder
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
     * Select brands.
     *
     * @return array
     * @throws Exception
     */
    public function selectBrands(): array
    {
        $sql = "SELECT * FROM Brands";

        $result = $this->dbConnection->query($sql);

        $brands = [];

        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $brands[] = [
                'id' => $row['id'],
                'type' => $row['type'],
                'amount' => $row['amount'],
                'sales' => $row['sales'],
                'created' => $row['created']
            ];
        }

        if ($this->dbConnection->query($sql)) {
            return $brands;
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Select brand by id.
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function selectBrand($id): array
    {
        $sql = "SELECT * FROM Brands WHERE id = {$id}";

        if ($this->dbConnection->query($sql)) {
            return $this->dbConnection->query($sql)->fetch_assoc();
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Insert new brand.
     *
     * @param $newBrand
     * @return array|false|null
     * @throws Exception
     */
    public function insertBrand($newBrand)
    {
        [
            'type' => $type,
            'amount' => $amount,
            'sales' => $sales,
            'created' => $created
        ] = $newBrand;

        $sql = "INSERT INTO Brands (type, amount, sales, created) VALUES ('$type','$amount', '$sales', '$created')";

        if ($this->dbConnection->query($sql)) {
            $createdBrandId = $this->dbConnection->insert_id;
            $createdBrandSql = "SELECT * FROM Brands WHERE id = {$createdBrandId}";

            return $this->dbConnection->query($createdBrandSql)->fetch_assoc();
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Update brand.
     *
     * @param $id
     * @param $parameters
     * @return array|false|null
     * @throws Exception
     */
    public function updateBrand($id, $parameters)
    {
        [
            'type' => $type,
            'amount' => $amount,
            'sales' => $sales,
            'created' => $created
        ] = $parameters;

        $sql = "UPDATE Brands SET type='$type', amount='$amount', sales='$sales', created='$created' WHERE id='$id'";
        $this->dbConnection->query($sql);

        if ($this->dbConnection->query($sql)) {
            $updatedBrandSql = "SELECT * FROM Brands WHERE id = {$id}";

            return $this->dbConnection->query($updatedBrandSql)->fetch_assoc();
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Delete brand.
     *
     * @param $id
     * @return string
     * @throws Exception
     */
    public function deleteBrand($id)
    {
        $sql = "DELETE FROM Brands WHERE id = {$id}";

        $this->dbConnection->query($sql);

        if ($this->dbConnection->query($sql)) {

            return "Brand has been deleted.";
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }
}
