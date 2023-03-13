let password_boxes = document.querySelectorAll('input[type="password"]');
let password_msg = document.querySelector(".password-message")

password_boxes.forEach(input => {
  input.addEventListener('change', function (e) {
    password_msg.textContent = "";
  })
})
