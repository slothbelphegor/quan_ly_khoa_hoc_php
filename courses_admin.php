<?
if (!isset($_SESSION['courses_management_access'])) {
    header("Location: index.php");
}

?>

<h1>Quản lý khoá học</h1>
<?php if (!empty($courses)) : ?>
    <table>
        <thead>
            <tr>
                <th class="shortcell">Tên</th>
                <th class="shortcell">Mô tả</th>
                <th class="shortcell">Giá</th>
                <th class="shortcell">Hình ảnh</th>
                <th class="shortcell">Thời lượng</th>
                <th class="shortcell">Loại khóa học</th>
                <th class="shortcell">Chức năng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course) : ?>
                <tr>
                    <td><?php echo $course['name']; ?></td>
                    <td><?php echo $course['description']; ?></td>
                    <td><?php echo $course['price']; ?></td>
                    <td>
                        <div class="image-container">
                            <?php if ($course['image'] && file_exists("uploads/" . $course['image'])) : ?>
                                <img src="uploads/<?php echo $course['image']; ?>" width="80" height="80">
                            <?php else : ?>
                                <img src="images/noimage.png" width="80" height="80">
                            <?php endif; ?>
                            <a href="editimage.php?id=<? echo $course['id'] ?>" class="edit-link">Sửa ảnh</a>
                        </div>
                    </td>

                    <td class='shortcell'><?php echo $course['duration']; ?></td>
                    <td class='shortcell'><?php echo $course['category_name']; ?></td>
                    <td class='shortcell'>
                        <button value="<? echo $course['id'] ?>" name="id" id="btnChangeCourse" class='btnCRUD'>Sửa khoá học</button>
                        <button value="<? echo $course['id'] ?>" name="id" id="btnDeleteCourse" class='btnCRUD'>Xoá khoá học</button>
                        <!-- <button value="<? echo $course['id'] ?>" name="id" id="btnEditImage" class='btnCRUD'>Sửa hình</button> -->
                        <?php if ($course['deleted'] == false) : ?>
                            <button value="<?php echo $course['id']; ?>" name="id" id="btnHideCourse" class='btnCRUD'>Ẩn khóa học</button>
                        <?php else : ?>
                            <button value="<?php echo $course['id']; ?>" name="id" id="btnShowCourse" class='btnCRUD'>Hiện khóa học</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <? endforeach; ?>
        </tbody>
        <? if (!isset($_GET['search'])) : ?>
            <tfoot>
                <tr>
                    <th colspan=4 style="text-align:center;">Tổng số khóa học: </td>
                    <td colspan=3 style=><? echo $config['total'] ?></td>
                </tr>

            </tfoot>
        <? endif; ?>
    </table>
<?php else : ?>
    <p>Không tìm thấy kết quả phù hợp</p>
<?php endif; ?>

<style>
    thead th {
        position: sticky;
        top: 0;
        /* Đặt phần tử ở vị trí cố định khi cuộn trang */
        background-color: #d5d1defe;
        cursor: pointer;
        text-transform: capitalize;
        z-index: 2;
        /* Đảm bảo thẻ th nằm trên cùng của lớp Z */
    }

    .image-container {
        position: relative;
        display: inline-block;
        /* Để phần tử span hiển thị ngay dưới ảnh */
    }

    .edit-link {
        position: absolute;
        top: 50%;
        /* Đặt ở giữa theo chiều dọc */
        left: 50%;
        /* Đặt ở giữa theo chiều ngang */
        transform: translate(-50%, -50%);
        /* Để đưa nút về vị trí chính giữa */
        background-color: rgba(0, 0, 0, 0.5);
        /* Màu nền cho liên kết */
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        /* Loại bỏ gạch chân mặc định */
        opacity: 0;
        /* Ẩn liên kết ban đầu */
        transition: opacity 0.3s;
        /* Hiệu ứng mờ dần */
    }

    .image-container:hover .edit-link {
        opacity: 1;
        /* Hiển thị liên kết khi hover vào */

    }

    .image-container {
        position: relative;
        display: inline-block;
        z-index: 1;
    }
</style>