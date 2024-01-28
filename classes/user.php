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


    // public function __construct($name = '', $email = '', $phone = '', $address = '', $password = ''){
    //     if($name = '' && $email = '' && $phone = '' && $address = '' && $password = ''){
    //         $this->name = $name;
    //         $this->email = $email;
    //         $this->phone = $phone;
    //         $this->address = $address;
    //         $this->password = $password;
    //     }
    // }

    // public function __construct($name = null, $email = null, $phone = null, $address = null, $password = null)
    // {
    //     $this->name = $name;
    //     $this->email = $email;
    //     $this->phone = $phone;
    //     $this->address = $address;
    //     $this->password = $password;
    // }
    // public function __construct($name = null, $email = null, $phone = null, $address = null, $password = null)
    // {
    //     if($name = '' && $email = '' && $phone = '' && $address = '' && $password = ''){
    //         $this->name = $name;
    //         $this->email = $email;
    //         $this->phone = $phone;
    //         $this->address = $address;
    //         $this->password = $password;
    //     }
    // }

    public function __construct($name = null, $email = null, $phone = null, $address = null, $password = null)
    {
        // Gán giá trị cho thuộc tính chỉ khi giá trị đó hợp lệ
        if ($name !== null) {
            $this->name = $name;
        }
        if ($email !== null) {
            $this->email = $email;
        }
        if ($phone !== null) {
            $this->phone = $phone;
        }
        if ($address !== null) {
            $this->address = $address;
        }
        if ($password !== null) {
            $this->password = $password;
        }
    }



    protected function validate()
    {
        $rs = $this->name != '' && $this->email != '' && $this->phone != '' && $this->address != '' && $this->password != '';
        return $rs;
    }
    public static function authenticate($conn, $email, $password)
    {
        $sql = "select * from users where email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        // $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $stmt->execute();
        $user = $stmt->fetch();
        echo '<pre>';
        print_r($user);
        echo '</pre>';

        if ($user) {
            $hash = $user->password;
            return password_verify($password, $hash);
        }
        // return false;
    }

    public function addUser($conn)
    {
        try {
            if ($this->validate()) {

                $sql = 'insert into users(name, email, phone, address, password) values(:name, :email, :phone, :address, :password);';
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":name", $this->name, PDO::PARAM_STR);
                $stmt->bindValue(":email", $this->email, PDO::PARAM_STR);
                $stmt->bindValue(":phone", $this->phone, PDO::PARAM_STR);
                $stmt->bindValue(":address", $this->address, PDO::PARAM_STR);

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
    //     echo $this->getName();
    //     $sql = 'insert into users(name, email, phone, address, password) values(:name, :email, :phone, :address, :password);';
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindValue(":name", $this->name, PDO::PARAM_STR);
    //     $stmt->bindValue(":email", $this->email, PDO::PARAM_STR);
    //     $stmt->bindValue(":phone", $this->phone, PDO::PARAM_STR);
    //     $stmt->bindValue(":address", $this->address, PDO::PARAM_STR);

    //     $hash = password_hash($this->password, PASSWORD_DEFAULT);
    //     $stmt->bindValue(":password", $hash, PDO::PARAM_STR);

    //     return $stmt->execute();
    // } 


}
