$(document).ready(function () {
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
        equalTo: "#password",
      },
    },
    messages: {
      name: "Vui lòng nhập họ tên",
      email: {
        required: "Vui lòng nhập email",
        email: "Email không hợp lệ",
      },
      phone: "Vui lòng nhập số điện thoại",
      address: "Vui lòng nhập địa chỉ",
      password: "Vui lòng nhập mật khẩu",
      repassword: {
        equalTo: "Mật khẩu xác nhận không khớp",
      },
    },
    // submitHandler: function (form) {
    //   $.ajax({
    //     url: "register.php",
    //     type: "POST",
    //     data: $(form).serialize(),
    //     success: function (response) {
    //       $("#frmREGISTER").hide(); // Ẩn form sau khi thêm thành công
    //       $(".success-message").text(response).show(); // Hiển thị thông báo thành công
    //     },
    //     error: function (jqXHR, textStatus, errorThrown) {
    //       console.error("Lỗi:", textStatus, errorThrown);
    //       $(".error-message").text("Lỗi không xác định").show(); // Hiển thị thông báo lỗi chung
    //     },
    //   });
    // },
  });
});
