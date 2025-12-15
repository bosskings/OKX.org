const menuOverlay = document.getElementById('menuOverlay');

function menuOpen() {
  menuOverlay && menuOverlay.classList.add('open');
}

function closeMenu() {
  menuOverlay && menuOverlay.classList.remove('open');
}

function createAccount() {
  window.location.href = "/dashboard/dashboard.html";
}


function togglePassword() {
  const passwordInput = document.getElementById('password-input');
  const icon = document.getElementById('togglePasswordIcon');
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    icon.classList.remove('fa-eye');
    icon.classList.add('fa-eye-slash');
  } else {
    passwordInput.type = "password";
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
  }
}

// for signup error messages
setTimeout(function() {
  var el = document.getElementById('error-message');
  if (el) el.style.display = 'none';
}, 5000);