<?php

class TaskGateway
{
    private PDO $conn;

    public function __construct(Database $db)
    {
        $this->conn = $db->getConnection();
    }

    public function getAllTasksList(): array {
        $sql = "SELECT * FROM task ORDER BY name";

        // will return a PDO statement object
        $stmt = $this->conn->query($sql);

        // call fetchAll to get an array of all methods
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}