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

    public static function getRole($conn)
    {
        try {
            $sql = "select * from roles";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute()) {
                $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $roles;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function getRoleName($conn, $id)
    {
        try {
            $sql = "SELECT name FROM roles WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $role = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($role) {
                    return $role['name'];
                }
            }
            return 'Unknown';
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}
