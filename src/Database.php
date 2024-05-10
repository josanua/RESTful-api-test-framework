<?php

class Database
{
    private  $host;
    private  $name;
    private  $user;
    private  $password;

    public function __construct(
        string $host,
        string $name,
        string $user,
        string $password
    ) {
        $this->password = $password;
        $this->user = $user;
        $this->name = $name;
        $this->host = $host;
    }

    public function getConnection(): PDO {
        $dsn = "mysql:host=$this->host;dbname=$this->name";

        return new PDO($dsn, $this->user, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

}