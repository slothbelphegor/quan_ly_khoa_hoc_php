<?php
class Category
{
    private $id;
    private $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    private function validate(){
        return $this->name;
    }

    public function createCategory($conn)
    {
        if($this->validate()){
            $sql = "insert into categories(name) values(:name);";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":name", $this->name, PDO::PARAM_STR);
            return $stmt->execute();
        }else{
            return false;
        }
        
    }

    public function deleteCategory($conn, $id)
    {
        $sql = "delete from categories where id = :id;";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateCategory($conn, $id, $name)
    {
        $sql = "update categories set name = :name where id = :id;";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":name", $name, PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getCategory($conn)
    {
        try{
            $sql = "select * from categories";
            $stmt = $conn->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Category");
            if($stmt->execute()){
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $categories;
            }

        }catch(PDOException $e){
            echo $e->getMessage();
            return null;
        }
    }

    public function getCategoryById($conn, $id)
    {
        try{
            $sql = "select * from categories where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Category");
            if($stmt->execute()){
                $categories = $stmt->fetch();
                return $categories;
            }
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
        
    }

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
}
