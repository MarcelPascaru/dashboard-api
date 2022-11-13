<?php

namespace App\Http\QueryBuilders;

use Exception;

class TicketsQueryBuilder
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
     * Select tickets.
     *
     * @return array
     * @throws Exception
     */
    public function selectTickets(): array
    {
        $sql = "SELECT * FROM Tickets";

        $result = $this->dbConnection->query($sql);

        $tickets = [];

        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $tickets[] = [
                'id' => $row['id'],
                'type' => $row['type'],
                'price' => $row['price'],
                'sale_date' => $row['sale_date'],
                'sales' => $row['sales'],
                'created' => $row['created']
            ];
        }

        if ($this->dbConnection->query($sql)) {
            return $tickets;
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Select ticket by id.
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function selectTicket($id): array
    {
        $sql = "SELECT * FROM Tickets WHERE id = {$id}";

        if ($this->dbConnection->query($sql)) {
            return $this->dbConnection->query($sql)->fetch_assoc();
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Insert new ticket.
     *
     * @param $newTicket
     * @return array|false|null
     * @throws Exception
     */
    public function insertTicket($newTicket)
    {
        [
            'type' => $type,
            'price' => $price,
            'sale_date' => $sale_date,
            'sales' => $sales,
            'created' => $created
        ] = $newTicket;

        $sql = "INSERT INTO Tickets (type, price, sale_date, sales, created) VALUES ('$type', '$price', '$sale_date', '$sales', '$created')";

        if ($this->dbConnection->query($sql)) {
            $createdTicketId = $this->dbConnection->insert_id;
            $createdTicketSql = "SELECT * FROM Tickets WHERE id = {$createdTicketId}";

            return $this->dbConnection->query($createdTicketSql)->fetch_assoc();
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Update Ticket.
     *
     * @param $id
     * @param $parameters
     * @return array|false|null
     * @throws Exception
     */
    public function updateTicket($id, $parameters)
    {
        [
            'type' => $type,
            'price' => $price,
            'sale_date' => $sale_date,
            'sales' => $sales,
            'created' => $created
        ] = $parameters;

        $sql = "UPDATE Tickets SET type='$type', price='$price', sale_date='$sale_date', sales= '$sales', created='$created' WHERE id='$id'";
        $this->dbConnection->query($sql);

        if ($this->dbConnection->query($sql)) {
            $updatedTicketSql = "SELECT * FROM Tickets WHERE id = {$id}";

            return $this->dbConnection->query($updatedTicketSql)->fetch_assoc();
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

    /**
     * Delete ticket.
     *
     * @param $id
     * @return string
     * @throws Exception
     */
    public function deleteTicket($id)
    {
        $sql = "DELETE FROM Tickets WHERE id = {$id}";

        $this->dbConnection->query($sql);

        if ($this->dbConnection->query($sql)) {

            return "Ticket has been deleted.";
        } else {
            throw new Exception("ERROR: Could not able to execute $sql. " . mysqli_error($this->dbConnection));
        }
    }

}
