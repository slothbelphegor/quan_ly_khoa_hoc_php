<?php
class User
{
    private $id;
    private $name;
    private $email;
    private $phone;
    private $address;
    private $password;
    private $is_active;
    private $role_id;

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function __construct($name , $email, $phone, $address, $password, $is_active = 1, $role_id = 2)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->password = $password;
        $this->is_active = $is_active;
        $this->role_id = $role_id;
    }
    protected function validate()
    {
        $rs = $this->name != '' && $this->email != '' && $this->phone != '' && $this->address != '' && $this->password != '';
        return $rs;
    }
    public static function authenticatebyemail($conn, $email, $password)
    {
        $sql = "select * from users where email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $stmt->execute();
        $user = $stmt->fetchObject();

        if ($user && password_verify($password, $user->password)) {
            Auth::login();
            $_SESSION["user_id"] = $user->id;
            $_SESSION["role_id"] = $user->role_id;
            return true;
        }
        return false;
    }

    public static function authenticatebyphone($conn, $phone, $password)
    {
        $sql = "select * from users where phone = :phone";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":phone", $phone, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $stmt->execute();
        $user = $stmt->fetchObject();

        if ($user && password_verify($password, $user->password)) {
            Auth::login();
            $_SESSION["user_id"] = $user->id;
            $_SESSION["role_id"] = $user->role_id;
            return true;
        }
        return false;
    }

    public static function getUserInfo($conn, $id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function test($conn){
        echo $this->role_id;
    }

    public function addUser($conn)
    {
        try {
            if ($this->validate()) {
                $sql = 'insert into users(name, email, phone, address, password, is_active, role_id) values(:name, :email, :phone, :address, :password, :is_active, :role_id);';
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":name", $this->name, PDO::PARAM_STR);
                $stmt->bindValue(":email", $this->email, PDO::PARAM_STR);
                $stmt->bindValue(":phone", $this->phone, PDO::PARAM_STR);
                $stmt->bindValue(":address", $this->address, PDO::PARAM_STR);
                $stmt->bindValue(":is_active", $this->is_active, PDO::PARAM_INT);
                $stmt->bindValue(":role_id", $this->role_id, PDO::PARAM_INT);

                $hash = password_hash($this->password, PASSWORD_DEFAULT);
                $stmt->bindValue(":password", $hash, PDO::PARAM_STR);
                // echo "Biến name: " . $this->name; // test
                return $stmt->execute();
            } else {
                echo "Lỗi không hợp lệ <br>";
                return false;
            }
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        } finally {
            $conn = null;
        }
    }
}
