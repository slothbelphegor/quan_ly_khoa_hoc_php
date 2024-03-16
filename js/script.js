jQuery.validator.setDefaults({
  debug: true,
  success: "valid",
});
$(document).ready(function () {
  // Thêm logic kiểm tra ở đây
  $("#frmREGISTER").validate({
    rules: {
      name: "required",
      email: {
        required: true,
        email: true,
      },
      username: "required",
      address: "required",
      password: "required",
      repassword: {
        required: true,
        equalTo: "#password", // Đảm bảo giống với mật khẩu
      },
    },
    messages: {
      name: "Vui lòng nhập họ tên đầy đủ của bạn",
      email: {
        required: "Vui lòng nhập địa chỉ email",
        email: "Vui lòng nhập địa chỉ email hợp lệ",
      },
      username: "Vui lòng nhập tên người dùng",
      address: "Vui lòng nhập địa chỉ của bạn",
      password: "Vui lòng nhập mật khẩu",
      repassword: {
        required: "Vui lòng xác nhận mật khẩu",
        equalTo: "Mật khẩu không khớp",
      },
    },
    submitHandler: function (form) {
      $.ajax({
        url: "register.php",
        type: "POST",
        data: $(form).serialize(),
        success: function (response) {
          $("#frmREGISTER").hide(); // Ẩn form sau khi thêm thành công
          $(".success-message").text(response).show(); // Hiển thị thông báo thành công
          redirectToLogin();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("Lỗi:", textStatus, errorThrown);
          $(".error-message").text("Lỗi không xác định").show(); // Hiển thị thông báo lỗi chung
        },
      });
    },
  });
});
$(document).ready(function () {
  // Thêm logic kiểm tra ở đây
  $("#frmADDUSER").validate({
    rules: {
      name: "required",
      email: {
        required: true,
        email: true,
      },
      username: "required",
      address: "required",
      password: "required",
      repassword: {
        required: true,
        equalTo: "#password", // Đảm bảo giống với mật khẩu
      },
    },
    messages: {
      name: "Vui lòng nhập họ tên đầy đủ của bạn",
      email: {
        required: "Vui lòng nhập địa chỉ email",
        email: "Vui lòng nhập địa chỉ email hợp lệ",
      },
      username: "Vui lòng nhập tên người dùng",
      address: "Vui lòng nhập địa chỉ của bạn",
      password: "Vui lòng nhập mật khẩu",
      repassword: {
        required: "Vui lòng xác nhận mật khẩu",
        equalTo: "Mật khẩu không khớp",
      },
    },
    submitHandler: function (form) {
      $.ajax({
        url: "adduser.php",
        type: "POST",
        data: $(form).serialize(),
        success: function (response) {
          $("#frmADDUSER").hide();
          $(".success-message").text(response).show();
          redirectToLogin();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("Lỗi:", textStatus, errorThrown);
          $(".error-message").text("Lỗi không xác định").show();
        },
      });
    },
  });
});

// hàm chuyển trang dăng nhập sau khi đăng ký thành công
function redirectToLogin() {
  window.location.href = "login.php";
}

function redirectToIndex() {
  window.location.href = "index.php";
}

const buyCourseBtns = document.querySelectorAll("#buy-course-btn");

buyCourseBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    const course_id = btn.dataset.course_id;

    // Gửi thông tin khóa học đến server bằng Ajax
    axios
      .post("/buy_course.php", {
        course_id,
      })
      .then((res) => {
        // Xử lý phản hồi từ server
        if (res.data.success) {
          // Hiển thị thông báo thành công và cập nhật giao diện
          alert("Mua khóa học thành công!");
          // Cập nhật giao diện để cho biết người dùng đã sở hữu khóa học
        } else {
          // Hiển thị thông báo lỗi
          alert("Mua khóa học thất bại!");
        }
      })
      .catch((err) => {
        // Hiển thị thông báo lỗi
        alert("Có lỗi xảy ra khi mua khóa học!");
      });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  var buttons = document.querySelectorAll("#btnBuyCourse");
  buttons.forEach(function (button) {
    button.addEventListener("click", function () {
      // Lấy giá trị id của khóa học từ thuộc tính value của nút
      var courseId = this.value;
      // Chuyển hướng sang trang buy_course.php với tham số id
      window.location.href = "buy_course.php?id=" + courseId;
    });
  });
});



document.addEventListener("DOMContentLoaded", function () {
  var buttons = document.querySelectorAll("#btnChangeCourse");
  buttons.forEach(function (button) {
    button.addEventListener("click", function () {
      // Lấy giá trị id của khóa học từ thuộc tính value của nút
      var courseId = this.value;
      window.location.href = "editcourse.php?id=" + courseId;
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  var addCourseBtn = document.getElementById("addcoursebtn");
  if (addCourseBtn) {
    addCourseBtn.addEventListener("click", function () {
      // Chuyển hướng người dùng đến trang addcourse.php
      window.location.href = "addcourse.php";
    });
  }
});
document.addEventListener("DOMContentLoaded", function () {
  var buttons = document.querySelectorAll("#btnEditImage");
  buttons.forEach(function (button) {
    button.addEventListener("click", function () {
      // Lấy giá trị id của khóa học từ thuộc tính value của nút
      var courseId = this.value;
      window.location.href = "editimage.php?id=" + courseId;
    });
  });
});

// ham xu ly nut dang xuat
document.addEventListener("DOMContentLoaded", function () {
  var logoutBtn = document.getElementById("logoutbtn");
  if (logoutBtn) {
    logoutBtn.addEventListener("click", function () {
      // Xác nhận trước khi đăng xuất
      var confirmLogout = confirm("Bạn có muốn đăng xuất?");
      if (confirmLogout) {
        // Chuyển hướng người dùng đến trang logout.php
        window.location.href = "logout.php";
      }
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  var btn = document.getElementById("changepassbtn");
  if (btn) {
    btn.addEventListener("click", function () {
      window.location.href = "change_password.php";
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  var buttons = document.querySelectorAll("#btnDeleteCourse");
  buttons.forEach(function (button) {
    button.addEventListener("click", function () {
      var confirmDEL = confirm("SURE!?");
      if (confirmDEL) {
        // Lấy giá trị id của khóa học từ thuộc tính value của nút
        var courseId = this.value;
        // Chuyển hướng sang trang buy_course.php với tham số id
        window.location.href = "delete_course.php?id=" + courseId;
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  var buttons = document.querySelectorAll("#btnHideCourse");
  buttons.forEach(function (button) {
    button.addEventListener("click", function () {
      var confirmDEL = confirm("SURE!?");
      if (confirmDEL) {
        // Lấy giá trị id của khóa học từ thuộc tính value của nút
        var courseId = this.value;
        // Chuyển hướng sang trang buy_course.php với tham số id
        window.location.href = "hide_course.php?id=" + courseId;
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  var buttons = document.querySelectorAll("#btnShowCourse");
  buttons.forEach(function (button) {
    button.addEventListener("click", function () {
      var confirmDEL = confirm("SURE!?");
      if (confirmDEL) {
        // Lấy giá trị id của khóa học từ thuộc tính value của nút
        var courseId = this.value;
        // Chuyển hướng sang trang buy_course.php với tham số id
        window.location.href = "show_course.php?id=" + courseId;
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  var buttons = document.querySelectorAll("#btnDeactive");
  buttons.forEach(function (button) {
    button.addEventListener("click", function () {
      var confirmDEL = confirm("SURE!?");
      if (confirmDEL) {
        var courseId = this.value;
        window.location.href = "deactive_user.php?id=" + courseId;
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  var buttons = document.querySelectorAll("#btnActive");
  buttons.forEach(function (button) {
    button.addEventListener("click", function () {
      var confirmDEL = confirm("SURE!?");
      if (confirmDEL) {
        var courseId = this.value;
        window.location.href = "active_user.php?id=" + courseId;
      }
    });
  });
});