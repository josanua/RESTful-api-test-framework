<?php

class TaskGateway
{
    private PDO $conn;

    public function __construct(Database $db)
    {
        $this->conn = $db->getConnection();
    }

    public function getAllTasksList(): array
    {
        $sql = "SELECT * FROM task ORDER BY name";

        // will return a PDO statement object
        $stmt = $this->conn->query($sql);

        // call fetchAll to get an array of all methods
        // return $stmt->fetchAll(PDO::FETCH_ASSOC);

        // transform int to bool
        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            // casting int val. to boolean
            $row['is_completed'] = (bool)$row['is_completed'];

            $data[] = $row;
        }

        return $data;
    }

    public function get(string $id): array|false
    {
        $sql = "SELECT * FROM task WHERE id = :id";

        // use prepare() to avoid SQL injections.
        $stmt = $this->conn->prepare($sql);

        // bind value as int type
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data !== false) {
            // casting int val. to boolean
            $data['is_completed'] = (bool)$data['is_completed'];
        }

        // return data will contain an array or false value
        return $data;
    }

    public function create(array $data): string
    {
        $sql = "INSERT INTO task (name, priority, is_completed) 
                VALUES (:name, :priority, :is_completed)";

        // prepare method
        $stmt = $this->conn->prepare($sql);

        // bind values
        $stmt->bindValue(":name", $data['name'], PDO::PARAM_STR);

        if (empty($data['priority'])) {
            $stmt->bindValue(":priority", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(":priority", $data['priority'], PDO::PARAM_INT);
        }

        $stmt->bindValue(":is_completed", $data['is_completed'] ?? false, PDO::PARAM_BOOL);

        // execute
        $stmt->execute();

        // return last created id
        return $this->conn->lastInsertId();
    }
}