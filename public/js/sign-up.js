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



// for phone number code pre-selection
// Map country names to phone codes for fallback/manual setting
const countryPhoneCodes = {
  "United States": "+1",
  "Canada": "+1",
  "United Kingdom": "+44",
  "Australia": "+61",
  "India": "+91",
  "Germany": "+49",
  "France": "+33",
  "Italy": "+39",
  "Spain": "+34",
  "Nigeria": "+234",
  "Belgium": "+32",
  "Switzerland": "+41",
  "Sweden": "+46",
  "Norway": "+47",
  "Denmark": "+45",
  "Finland": "+358",
  "Japan": "+81",
  "South Korea": "+82",
  "China": "+86",
  "Brazil": "+55",
  "Mexico": "+52",
  "South Africa": "+27",
  "Singapore": "+65",
  "Hong Kong": "+852",
  "New Zealand": "+64",
  "Thailand": "+66"
};

// On country change, set phone prefix
document.addEventListener('DOMContentLoaded', function() {
  const countrySelect = document.getElementById('country-select');
  const phoneInput = document.getElementById('phone-input');

  function setPhoneCode() {
    const selected = countrySelect.options[countrySelect.selectedIndex];
    const code = selected.getAttribute('data-phone-code');
    if (code && (!phoneInput.value || phoneInput.value.charAt(0) !== '+')) {
      phoneInput.value = code + ' ';
    }
  }

  countrySelect.addEventListener('change', setPhoneCode);

  // On page load, if value in country exists & phone is blank, set prefix (for old input)
  const oldCountry = "{{ old('country') }}";
  if (oldCountry && !phoneInput.value && countryPhoneCodes[oldCountry]) {
    phoneInput.value = countryPhoneCodes[oldCountry] + ' ';
  }
});