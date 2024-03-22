jQuery.validator.setDefaults({
  debug: true,
  success: "valid",
});
$(document).ready(function () {
  // Thêm logic kiểm tra ở đây
  $("#frmREGISTER").validate({
    rules: {
      name: {
        required: true,
        pattern: "^[A-Za-z][a-zA-Z .]+$",
      },
      email: {
        required: true,
        email: true,
      },

      username: {
        required: true,
        minlength: 6,
        maxlength: 20,
        pattern:"^[A-Za-z0-9_.]+$"
      },
      address: "required",
      password: {
        required: true,
        minlength: 8,
        pattern: "^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$",
      },
      repassword: {
        required: true,
        equalTo: "#password", // Đảm bảo giống với mật khẩu
      },
    },
    messages: {
      name: {
        required: "Vui lòng nhập họ tên",
        pattern: "Không được sử dụng ký tự đặc biệt, phải bắt đầu bằng chữ cái"
      },
      email: {
        required: "Vui lòng nhập địa chỉ email",
        email: "Vui lòng nhập địa chỉ email hợp lệ",
      },
      username: {
        required: "Vui lòng nhập tên tài khoản",
        minlength: "Ít nhất 6 ký tự",
        maxlength: "Nhiều nhất 20 ký tự",
        pattern:"Không chứa ký tự đặc biệt ngoại trừ dấu chấm và dấu gạch dưới"
      },
      address: "Vui lòng nhập địa chỉ của bạn",
      password: {
        required: "Vui lòng nhập mật khẩu",
        minlength: "Ít nhất 8 ký tự",
        pattern: "Mật khẩu phải bao gồm chữ hoa, chữ thường, chữ số và ký tự đặc biệt"
      },
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
          alert("Thành công!");
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

// $(document).ready(function () {
//   // Thêm logic kiểm tra ở đây
//   $("#frmEDITPROFILE").validate({
//     rules: {
//       name: {
//         required: true,
//         minlength: 6,
//         pattern: "^[A-Za-z]*$"
//       },
//       email: {
//         required: true,
//         email: true,
//       },
//       address: "required",


//     },
//     messages: {
//       name: {
//         required: "Vui lòng nhập họ tên",
//         minlength: "Ít nhất 6 ký tự",

//         pattern: "Giá trị tên không hợp lệ"
//       },
//       email: {
//         required: "Vui lòng nhập địa chỉ email",
//         email: "Vui lòng nhập địa chỉ email hợp lệ",
//       },
//       address: "Vui lòng nhập địa chỉ của bạn",

//     },
//     submitHandler: function (form) {
//       $.ajax({
//         url: "myaccount.php",
//         type: "POST",
//         data: $(form).serialize(),
//         success: function (response) {
//           $("#frmEDITPROFILE").hide(); // Ẩn form sau khi thêm thành công
//           $(".success-message").text(response).show(); // Hiển thị thông báo thành công
//           alert("Thành công");
//         },
//         error: function (jqXHR, textStatus, errorThrown) {
//           console.error("Lỗi:", textStatus, errorThrown);
//           $(".error-message").text("Lỗi không xác định").show(); // Hiển thị thông báo lỗi chung
//         },
//       });
//     },
//   });
// });

$(document).ready(function () {
  // Thêm logic kiểm tra ở đây
  $("#frmADDUSER").validate({
    rules: {
      name: {
        required: true,
        pattern: "^[A-Za-z][a-zA-Z .]+$",
      },
      email: {
        required: true,
        email: true,
      },
      username: {
        required: true,
        minlength: 6,
        maxlength: 20,
        pattern:"^[A-Za-z0-9_.]+$"
      },
      address: "required",
      password: {
        required: true,
        minlength: 8,
        pattern: "^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$",
      },
      repassword: {
        required: true,
        equalTo: "#password", // Đảm bảo giống với mật khẩu
      },
    },
    messages: {
      name: {
        required: "Vui lòng nhập họ tên",
        pattern: "Không được sử dụng ký tự đặc biệt, phải bắt đầu bằng chữ cái"
      },
      email: {
        required: "Vui lòng nhập địa chỉ email",
        email: "Vui lòng nhập địa chỉ email hợp lệ",
      },
      username: {
        required: "Vui lòng nhập tên tài khoản",
        minlength: "Ít nhất 6 ký tự",
        maxlength: "Nhiều nhất 20 ký tự",
        pattern:"Không chứa ký tự đặc biệt ngoại trừ dấu chấm và dấu gạch dưới"
      },
      address: "Vui lòng nhập địa chỉ của bạn",
      password: {
        required: "Vui lòng nhập mật khẩu",
        minlength: "Ít nhất 8 ký tự",
        pattern: "Mật khẩu phải bao gồm chữ hoa, chữ thường, chữ số và ký tự đặc biệt"
      },
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
          alert("Thành công");
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

// document.addEventListener("DOMContentLoaded", function () {
//   var addCourseBtn = document.getElementById("#addcoursebtn");
//   if (addCourseBtn) {
//     addCourseBtn.addEventListener("click", function () {
//       // Chuyển hướng người dùng đến trang addcourse.php
//       window.location.href = "addcourse.php";
//     });
//   }
// });

document.addEventListener("DOMContentLoaded", function () {
  var registerBtn = document.querySelector(".ad_btn");
  if (registerBtn) {
    registerBtn.addEventListener("click", function () {
      // Chuyển hướng người dùng đến trang addcourse.php
      window.location.href = "register.php";
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
  var logoutBtn = document.getElementById("btnLogOut");
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
  var btn = document.getElementById("btnChangePass");
  if (btn) {
    btn.addEventListener("click", function () {
      window.location.href = "change_password.php";
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  var btn = document.getElementById("btnAddCourse");
  if (btn) {
    btn.addEventListener("click", function () {
      window.location.href = "addcourse.php";
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