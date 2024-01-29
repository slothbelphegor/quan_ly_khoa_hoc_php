// $(document).ready(function () {
//   $("#frmREGISTER").validate({
//     rules: {
//       name: "required",
//       email: {
//         required: true,
//         email: true,
//       },
//       phone: "required",
//       address: "required",
//       password: "required",
//       repassword: {
//         equalTo: "#password",
//       },
//     },
//     messages: {
//       name: "Vui lòng nhập họ tên",
//       email: {
//         required: "Vui lòng nhập email",
//         email: "Email không hợp lệ",
//       },
//       phone: "Vui lòng nhập số điện thoại",
//       address: "Vui lòng nhập địa chỉ",
//       password: "Vui lòng nhập mật khẩu",
//       repassword: {
//         equalTo: "Mật khẩu xác nhận không khớp",
//       },
//     },
//   });
// });
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});
$(document).ready(function () {
  // Thêm logic kiểm tra ở đây
  $("#frmREGISTER").validate({
      rules: {
          name: "required",
          email: {
              required: true,
              email: true
          },
          phone: "required",
          address: "required",
          password: "required",
          repassword: {
              required: true,
              equalTo: "#password" // Đảm bảo giống với mật khẩu
          }
      },
      messages: {
          name: "Vui lòng nhập họ tên đầy đủ của bạn",
          email: {
              required: "Vui lòng nhập địa chỉ email",
              email: "Vui lòng nhập địa chỉ email hợp lệ"
          },
          phone: "Vui lòng nhập số điện thoại của bạn",
          address: "Vui lòng nhập địa chỉ của bạn",
          password: "Vui lòng nhập mật khẩu",
          repassword: {
              required: "Vui lòng xác nhận mật khẩu",
              equalTo: "Mật khẩu không khớp"
          }
      },
      submitHandler: function (form) {
        $.ajax({
          url: "register.php",
          type: "POST",
          data: $(form).serialize(),
          success: function (response) {
            $("#frmREGISTER").hide(); // Ẩn form sau khi thêm thành công
            $(".success-message").text(response).show(); // Hiển thị thông báo thành công
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error("Lỗi:", textStatus, errorThrown);
            $(".error-message").text("Lỗi không xác định").show(); // Hiển thị thông báo lỗi chung
          },
        });
      },
  });
});
