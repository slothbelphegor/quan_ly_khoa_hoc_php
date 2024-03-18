<?php
class User
{
    private $id;
    private $name;
    private $email;
    private $username;
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
    public function __construct($name, $email, $username, $address, $password, $is_active = 1, $role_id = 2)
    {
        $this->name = $name;
        $this->email = $email;
        $this->username = $username;
        $this->address = $address;
        $this->password = $password;
        $this->is_active = $is_active;
        $this->role_id = $role_id;
    }
    protected function validate()
    {
        $rs = $this->name != '' && $this->email != '' && $this->username != '' && $this->address != '' && $this->password != '';
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

    public static function authenticatebyusername($conn, $username, $password)
    {
        $sql = "select * from users where username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);
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
        $sql = "select * from users where id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public static function getAllUserInfo($conn)
    {
        try {
            $sql = "select u.id, u.name, u.email, u.username, u.address, u.is_active, u.role_id from users u;";
            $stmt = $conn->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if ($stmt->execute()) {
                $users = $stmt->fetchAll();
                return $users;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function searchUser($conn, $search)
    {
        try {
            $sql = "select u.id, u.name, u.email, u.username, u.address, u.is_active, u.role_id from users u
                    where (u.id like :search_term or u.name like :search_term or u.username like :search_term);";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':search_term', "%$search%", PDO::PARAM_STR);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if ($stmt->execute()) {
                $users = $stmt->fetchAll();
                return $users;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function deactiveUser($conn, $id)
    {
        try {
            $sql = "update users set is_active = false where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }
    public static function activeUser($conn, $id)
    {
        try {
            $sql = "update users set is_active = true where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }

    public static function isUserActive($conn, $identifier)
    {
        try {
            $sql = "select is_active from users where email = :email OR username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':email', $identifier, PDO::PARAM_STR);
            $stmt->bindValue(':username', $identifier, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user && $user['is_active'] == 1;
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }

    public static function emailExists($conn, $email)
    {
        try {
            $sql = "select count(*) as count from users where email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":email", $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['count'] > 0;
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }

    public static function updatePassword($conn, $email, $newPassword)
    {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Truy vấn cập nhật mật khẩu trong cơ sở dữ liệu
            $sql = "update users set password = :password where email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":password", $hashedPassword);
            $stmt->bindValue(":email", $email);

            return $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }

    public function addUser($conn)
    {
        try {
            if ($this->validate()) {
                $sql = 'insert into users(name, email, username, address, password, is_active, role_id) values(:name, :email, :username, :address, :password, :is_active, :role_id);';
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":name", $this->name, PDO::PARAM_STR);
                $stmt->bindValue(":email", $this->email, PDO::PARAM_STR);
                $stmt->bindValue(":username", $this->username, PDO::PARAM_STR);
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

    public static function updateUserInfo($conn, $id, $name, $email, $address)
    {
        try {
            $sql = "update users set name = :name, email = :email, address = :address where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":name", $name, PDO::PARAM_STR);
            $stmt->bindValue(":email", $email, PDO::PARAM_STR);
            $stmt->bindValue(":address", $address, PDO::PARAM_STR);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
