<?php
class Role
{
    private $id;
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function createRole($conn)
    {
        $sql = "insert into roles(name) values(:name);";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":name", $this->name, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
