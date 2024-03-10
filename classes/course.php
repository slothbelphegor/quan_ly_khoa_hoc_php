<?php
class Course
{
    private $id;
    private $name;
    private $description;
    private $price;
    private $image;
    private $video;
    private $duration;
    private $category_id;

    private $deleted;


    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image)
    {
        $this->image = $image;
    }
    public function getVideo()
    {
        return $this->video;
    }
    public function setVideo($video)
    {
        $this->video = $video;
    }
    public function getDuration()
    {
        return $this->duration;
    }
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }
    public function getCategoryId()
    {
        return $this->category_id;
    }
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    public function __construct($name, $description, $price, $image, $video, $duration, $category_id, $deleted = false)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;
        $this->video = $video;
        $this->duration = $duration;
        $this->category_id = $category_id;
        $this->deleted = $deleted;

    }

    // Mỗi khóa học tối thiểu phải có tên, mô tả, giá bán và mã phân loại 
    // (sau này phải dùng validation form để xác nhận và bỏ hàm này)
    private function validate()
    {
        $rs = $this->name && $this->description && $this->price && $this->category_id;
        return $rs;
    }

    // Thêm khóa học
    public function addCourse($conn)
    {
        if ($this->validate()) {
            $sql = "insert into courses(name,description,price,image,video,duration,category_id) 
                    values (:name,:description,:price,:image,:video,:duration,:category_id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':description', $this->description, PDO::PARAM_STR);
            $stmt->bindValue(':price', $this->price, PDO::PARAM_INT);
            $stmt->bindValue(':image', $this->image, PDO::PARAM_STR);
            $stmt->bindValue(':video', $this->video, PDO::PARAM_STR);
            $stmt->bindValue(':duration', $this->duration, PDO::PARAM_STR);
            $stmt->bindValue(':category_id', $this->category_id, PDO::PARAM_STR);
            return $stmt->execute();
        } else {
            return false;
        }
    }

    // Truy vấn toàn bộ khóa học
    // public static function getAll($conn)
    // {
    //     try {
    //         $sql = "select * from courses order by name asc";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->setFetchMode(PDO::FETCH_CLASS, 'Course');
    //         $stmt->execute();
    //         if ($stmt->execute()) {
    //             $courses = $stmt->fetchAll();
    //             return $courses;
    //         }
    //     } catch (PDOException $e) {
    //         echo $e->getMessage();
    //         return null;
    //     }
    // }
    public static function getAll($conn)
    {
        try {
            $sql = "select * from courses order by name asc";
            $stmt = $conn->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Course');
            if ($stmt->execute()) {
                $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $courses;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
    public static function getAllCustom($conn)
    {
        try {
            $sql = "select c.id, c.name, c.description, c.price, c.image, c.video, c.duration, categories.name as category_name
            from courses c
            join categories on c.category_id = categories.id 
            where c.deleted = false";
            $stmt = $conn->prepare($sql);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Course');
            if ($stmt->execute()) {
                $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $courses;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    //Truy vấn bằng ID
    public static function getByID($conn, $id)
    {
        try {
            $sql = "select * from courses where id=:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Course');
            if ($stmt->execute()) {
                $course = $stmt->fetchObject();
                return $course;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    // Hàm phân trang
    /*Chọn record cho trang thứ n: select * from db limit page_size, offset start
      Công thức tính start: start = (current_page - 1) * page_size */
    public static function getPaging($conn, $limit, $offset)
    {
        try {
            $sql = "select * from courses order by name asc, author asc
                      limit :limit
                      offset :offset";
            $stmt = $conn->prepare($sql);
            //limit: số record mỗi lần select
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            //offset: select từ record thứ mấy
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Course');
            $stmt->execute();
            if ($stmt->execute()) {
                $books = $stmt->fetchAll();
                return $books;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    // Sửa thông tin khóa học
    public function updateCourse($conn)
    {
        try {
            if ($this->validate()) {
                $sql = "update courses
                        set name=:name, description=:description, 
                        price=:price, image=:image, video=:video,
                        duration=:duration, category_id=:category_id
                        where id=:id";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
                $stmt->bindValue(':description', $this->description, PDO::PARAM_STR);
                $stmt->bindValue(':price', $this->price, PDO::PARAM_INT);
                $stmt->bindValue(':image', $this->image, PDO::PARAM_STR);
                $stmt->bindValue(':video', $this->video, PDO::PARAM_STR);
                $stmt->bindValue(':duration', $this->duration, PDO::PARAM_STR);
                $stmt->bindValue(':category_id', $this->category_id, PDO::PARAM_STR);
                $stmt->bindValue(':id', $this->id, PDO::PARAM_STR);
                return $stmt->execute();
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    //Xóa theo ID
    public function deleteByID($conn, $id)
    {
        try {
            $sql = "update courses set deleted = true";
            $stmt = $conn->prepare($sql);
            print $this;
            var_dump($stmt);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();

        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }
    public static function markAsDeleted($conn, $course_id)
    {
        try {
            $sql = "update courses set deleted = true where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $course_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }

    //Đổi hình minh họa (hoặc thêm nếu chưa có)
    public function updateImage($conn, $id, $image)
    {
        try {
            $sql = "update courses
                    set image=:image where id=:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            //$image có thể null
            $stmt->bindValue(
                ':image',
                $image,
                $image == null ? PDO::PARAM_NULL : PDO::PARAM_STR
            );
            return $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }

    //Đổi video minh họa (hoặc thêm nếu chưa có)
    public function updateVideo($conn, $id, $video, $duration)
    {
        try {
            $sql = "update courses
                    set video=:video, duration=:duration where id=:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            //$video có thể null
            $stmt->bindValue(
                ':video',
                $video,
                $video == null ? PDO::PARAM_NULL : PDO::PARAM_STR
            );
            $stmt->bindValue(
                ':duration',
                $duration,
                $duration == null ? PDO::PARAM_NULL : PDO::PARAM_STR
            );

            return $stmt->execute();
        } catch (PDOException $e) {
            $e->getMessage();
            return false;
        }
    }

    //Hàm đếm số records
    public static function count($conn)
    {

        try {
            $sql = "select count(id) from courses";
            return $conn->query($sql)->fetchColumn();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return -1;
        }
    }
}
