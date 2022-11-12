<?php

namespace App\Http\QueryBuilders;

use Exception;
use mysqli;

class DatabaseConnection
{
    /**
     * @throws Exception
     */
    public function connection(): mysqli
    {
        $servername = env('DB_HOST');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $dbname = env('DB_DATABASE');

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (!$conn) {
            throw new Exception("Connection failed: " . mysqli_connect_error());
        }

        return $conn;
    }
}
