<?php
class Course
{
    public $id;
    public $name;
    public $description;
    public $price;
    public $image;
    public $video;
    public $duration;
    public $category_id;
    public $deleted;

    public function __construct(
        $name = null,
        $description = null,
        $price = null,
        $image = null,
        $video = null,
        $duration = null,
        $category_id = null,
        $deleted = false
    ) {
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
            $sql = "select c.id, c.name, c.description, c.price, c.image, c.video, c.duration, categories.name as category_name, c.deleted
            from courses c
            join categories on c.category_id = categories.id 
            where c.deleted = false";
            if (Auth::isManager()) {
                $sql .= " or deleted = true";
            }
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
            $stmt->setFetchMode(PDO::FETCH_INTO, new Course());
            if ($stmt->execute()) {
                $course = $stmt->fetch();
                return $course;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function searchCourse($conn, $search)
    {
        try {
            $sql = "select c.id, c.name, c.description, c.price, c.image, c.video, c.duration, categories.name as category_name
                  from courses c
                  join categories on c.category_id = categories.id
                  where (c.name like :search_term or c.description like :search_term)";
            if (!Auth::isAdmin()) {
                $sql .= " and c.deleted = false )";
            }
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':search_term', "%$search%", PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return null;
        }
    }

    public static function searchCoursePaging($conn, $search, $limit, $offset)
    {
        try {
            $sql = "select c.id, c.name, c.description, c.price, c.image, c.video, c.duration, 
                    categories.name as category_name, c.deleted
                    from courses c
                    join categories on c.category_id = categories.id
                    where (c.name like :search_term or c.description like :search_term) ";
            if (!Auth::isAdmin()) {
                $sql .= "and c.deleted = false ";
            }
            $sql .= "limit :limit
                     offset :offset";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':search_term', "%$search%", PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return null;
        }
    }

    // Hàm phân trang
    /*Chọn record cho trang thứ n: select * from db limit page_size, offset start
      Công thức tính start: start = (current_page - 1) * page_size */
    public static function getPaging($conn, $limit, $offset)
    {
        try {
            $sql = "select c.id, c.name, c.description, c.price, c.image, c.video, c.duration, 
            categories.name as category_name, c.deleted
            from courses c
            join categories on c.category_id = categories.id 
            where c.deleted = false
            order by c.name asc
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
                $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $books;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public static function getPagingAll($conn, $limit, $offset)
    {
        try {
            $sql = "select c.id, c.name, c.description, c.price, c.image, c.video, c.duration, 
            categories.name as category_name, c.deleted
            from courses c
            join categories on c.category_id = categories.id 
            order by c.name asc
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
                $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public static function isCourseInOrders($conn, $course_id)
    {
        try {
            $sql = "select exists (select 1 from orders where course_id = :course_id) as course_exists";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":course_id", $course_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return (bool) $result['course_exists']; //true nếu course_id có trong orders, ngược lại trả về false
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function deleteCourse($conn, $course_id)
    {
        try {
            $sql = "delete from courses where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $course_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function delCourse($conn, $course_id)
    {
        try {
            if (self::isCourseInOrders($conn, $course_id)) {
                // Nếu course_id tồn tại trong bảng orders, chỉ cập nhật trạng thái deleted của course
                return self::markAsDeleted($conn, $course_id);
            } else {
                // Nếu course_id không tồn tại trong bảng orders, xóa cứng course
                return self::deleteCourse($conn, $course_id);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function markAsNotDeleted($conn, $course_id)
    {
        try {
            $sql = "update courses set deleted = false where id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $course_id, PDO::PARAM_INT);
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
    public function updateImage($conn)
    {
        try {
            $sql = "update courses
                    set image=:image where id=:id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            //$image có thể null
            $stmt->bindValue(
                ':image',
                $this->image,
                $this->image == null ? PDO::PARAM_NULL : PDO::PARAM_STR
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
            $sql = "select count(id) from courses where deleted = false";
            return $conn->query($sql)->fetchColumn();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return -1;
        }
    }

    public static function countAll($conn)
    {

        try {
            $sql = "select count(id) from courses";
            return $conn->query($sql)->fetchColumn();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return -1;
        }
    }

    public static function popularCategories($conn, $category_counts)
    {
        try {
            $most_purchased_category_id = $category_counts[0]['category_id'];
            $sql = "select id, name, description
            from courses
            where category_id = :category_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':category_id', $most_purchased_category_id, PDO::PARAM_INT);
            $stmt->execute();
            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $courses;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function popularCourses($conn, $limit, $offset)
    {
        try {
            $offset = max($offset, 1);
            $sql = "select c.id, c.name, c.description, c.price, c.image, c.video, c.duration, 
                    categories.name as category_name, c.deleted, count(o.course_id) AS orders_count
                    from courses c
                    left join orders o on c.id = o.course_id
                    join categories on c.category_id = categories.id 
                    where c.deleted = false
                    group by c.id
                    order by orders_count desc, c.name asc
                    limit :limit
                    offset :offset";
            $stmt = $conn->prepare($sql); //limit: số record mỗi lần select
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            //offset: select từ record thứ mấy
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $courses;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public static function popularCoursesAll($conn, $limit, $offset)
    {
        try {
            $offset = max($offset, 0);
            $sql = "select c.id, c.name, c.description, c.price, c.image, c.video, c.duration, 
                    categories.name as category_name, c.deleted, count(o.course_id) AS orders_count
                    from courses c
                    left join orders o on c.id = o.course_id
                    join categories on c.category_id = categories.id 
                    group by c.id
                    order by orders_count desc, c.name asc
                    limit :limit
                    offset :offset";
            $stmt = $conn->prepare($sql); //limit: số record mỗi lần select
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            //offset: select từ record thứ mấy
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $courses;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function searchPopularPaging($conn, $search, $limit, $offset)
    {
        try {
            $offset = max($offset, 0);
            $sql = "select c.id, c.name, c.description, c.price, c.image, c.video, c.duration, 
                categories.name as category_name, c.deleted
                from courses c
                join categories on c.category_id = categories.id
                left join orders o on c.id = o.course_id
                where (c.name like :search_term or c.description like :search_term) ";

            if (!Auth::isManager()) {
                $sql .= "and c.deleted = false ";
            }

            $sql .= "group by c.id
                 order by count(o.course_id) desc, c.name asc
                 limit :limit
                 offset :offset";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':search_term', "%$search%", PDO::PARAM_STR);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
            return null;
        }
    }

    public static function searchByCategoryAndTerm($conn, $search, $category_id, $limit, $offset)
    {
        try {
            $sql = "select c.id, c.name, c.description, c.price, c.image, c.video, c.duration, 
                    categories.name as category_name, c.deleted, count(o.course_id) as orders_count
                    from courses c
                    left join orders o on c.id = o.course_id
                    join categories on c.category_id = categories.id 
                    where c.category_id = :category_id
                    and (c.name like :search_term or c.description like :search_term)
            ";

            if (!Auth::isManager()) {
                $sql .= "and c.deleted = false ";
            }

            $sql .= "group by c.id
                    order by orders_count asc, c.name asc
                    limit :limit
                    offset :offset;";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':search_term', "%$search%", PDO::PARAM_STR);
            $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $courses;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}
