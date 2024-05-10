<?php

class TaskGateway
{
    private PDO $conn;
    public function __construct(Database $db)
    {
        $this->conn = $db->getConnection();
    }
}