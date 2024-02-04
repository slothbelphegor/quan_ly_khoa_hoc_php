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
      phone: "required",
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
      phone: "Vui lòng nhập số điện thoại của bạn",
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
      phone: "required",
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
      phone: "Vui lòng nhập số điện thoại của bạn",
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

$(document).ready(function () {
  $("#frmLOGIN").validate({
    rules: {
      identifier: "required",
      password: "required",
    },
    messages: {
      identifier: "Vui lòng nhập email hoặc số điện thoại",
      password: "Vui lòng nhập mật khẩu",
    },
    submitHandler: function (form, event) {
      event.preventDefault();
      $.ajax({
        url: "login.php",
        type: "POST",
        data: $(form).serialize(),
        success: function (response) {
          // $("#frmLOGIN").hide();
          $(".success-message").text(response).show();
          redirectToIndex();
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error("Lỗi:", textStatus, errorThrown);
          $(".error-message").text("Lỗi không xác định").show();
        },
      });
    },
  });
});

//Ham xu ly dang xuat
$(document).ready(function () {
  $("#logoutbtn").click(function () {
    if (window.confirm("Bạn có muốn đăng xuất?")) {
      $.ajax({
        url: "logout.php",
        method: "GET",
        success: function (response) {
          redirectToIndex();
        },
        error: function (xhr, status, error) {
          alert("Có lỗi xảy ra khi đăng xuất!");
        },
      });
    }
  });
});

// hàm chuyển trang dăng nhập sau khi đăng ký thành công
function redirectToLogin() {
  window.location.href = "login.php";
}

function redirectToIndex() {
  window.location.href = "index.php";
}
