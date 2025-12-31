<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="/css/sign-up.css">
  <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Belanosima:wght@400;600;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet">
</head>

<body>

  <div class="menu-overlay" id="menuOverlay">
    <button onclick="closeMenu()"><i class="fa fa-close"></i></button>
    <a href="/">HOME</a>
    <a href="/spot-trade">SPOT TRADES</a>
    <a href="/futures">FUTURE TRADES</a>
    <a href="/logout">Logout</a>
  </div>

  <!-- NVIGATION -->

  <nav>
    <div class="nav-left">
      <a href=""><img src="/images/logo.png" alt="Logo" width="100px"></a>
    </div>

    <div style="display: flex; gap: 20px; align-items: center;">
      <div class="nav-right">
        <i class="fa fa-search"></i>
        <a href="/login">Login</a>
        <a href="/sign-up" class="sup">Sign up</a>
        <i class="fa fa-bell"></i>
        <i class="fa fa-question-circle-o"></i>
      </div>

      <button onclick="menuOpen()" class="menu"><i class="fa fa-bars"></i></button>
    </div>
  </nav>

  <!-- MAIN LOIN -->

  <div class="sign-up">

    <div class="sign-up-left">
      <h2>Trade with confidence</h2>
      <p>We don't lend out customer funds, which is <br> verified through our regularly published Proof of <br> Reserves
        audits.
      </p>
      <img src="/images/sign-up.webp" alt="">
    </div>

    <div class="sign-up-right">

      <div class="user-inputs">

        <h2>Where do you live?</h2>
        <p class="response">Your response will be used to set up your account and verify your identity.</p>

        <div class="options">
          <p class="country">Country/region</p>
        </div>
        
        <form action="{{ route('register') }}" method="POST">
          @csrf

          @if(session('error'))
            <div id="error-message" style="background: #ffdddd; color: #c00; border: 1px solid #c00; padding: 10px; margin-bottom: 15px; border-radius: 5px; text-align: center;">
                {{ session('error') }}
            </div>
          @endif

          <!-- Country select with data-phone-code attribute for each option -->
          <select name="country" id="country-select" required>
            <option value="" data-phone-code="" disabled {{ old('country') ? '' : 'selected' }}>Select your country/region</option>
            <option value="United States" data-phone-code="+1" {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
            <option value="Canada" data-phone-code="+1" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
            <option value="United Kingdom" data-phone-code="+44" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
            <option value="Australia" data-phone-code="+61" {{ old('country') == 'Australia' ? 'selected' : '' }}>Australia</option>
            <option value="India" data-phone-code="+91" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
            <option value="Germany" data-phone-code="+49" {{ old('country') == 'Germany' ? 'selected' : '' }}>Germany</option>
            <option value="France" data-phone-code="+33" {{ old('country') == 'France' ? 'selected' : '' }}>France</option>
            <option value="Italy" data-phone-code="+39" {{ old('country') == 'Italy' ? 'selected' : '' }}>Italy</option>
            <option value="Spain" data-phone-code="+34" {{ old('country') == 'Spain' ? 'selected' : '' }}>Spain</option>
            <option value="Nigeria" data-phone-code="+234" {{ old('country') == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
            <option value="Belgium" data-phone-code="+32" {{ old('country') == 'Belgium' ? 'selected' : '' }}>Belgium</option>
            <option value="Switzerland" data-phone-code="+41" {{ old('country') == 'Switzerland' ? 'selected' : '' }}>Switzerland</option>
            <option value="Sweden" data-phone-code="+46" {{ old('country') == 'Sweden' ? 'selected' : '' }}>Sweden</option>
            <option value="Norway" data-phone-code="+47" {{ old('country') == 'Norway' ? 'selected' : '' }}>Norway</option>
            <option value="Denmark" data-phone-code="+45" {{ old('country') == 'Denmark' ? 'selected' : '' }}>Denmark</option>
            <option value="Finland" data-phone-code="+358" {{ old('country') == 'Finland' ? 'selected' : '' }}>Finland</option>
            <option value="Japan" data-phone-code="+81" {{ old('country') == 'Japan' ? 'selected' : '' }}>Japan</option>
            <option value="South Korea" data-phone-code="+82" {{ old('country') == 'South Korea' ? 'selected' : '' }}>South Korea</option>
            <option value="China" data-phone-code="+86" {{ old('country') == 'China' ? 'selected' : '' }}>China</option>
            <option value="Brazil" data-phone-code="+55" {{ old('country') == 'Brazil' ? 'selected' : '' }}>Brazil</option>
            <option value="Mexico" data-phone-code="+52" {{ old('country') == 'Mexico' ? 'selected' : '' }}>Mexico</option>
            <option value="South Africa" data-phone-code="+27" {{ old('country') == 'South Africa' ? 'selected' : '' }}>South Africa</option>
            <option value="Singapore" data-phone-code="+65" {{ old('country') == 'Singapore' ? 'selected' : '' }}>Singapore</option>
            <option value="Hong Kong" data-phone-code="+852" {{ old('country') == 'Hong Kong' ? 'selected' : '' }}>Hong Kong</option>
            <option value="New Zealand" data-phone-code="+64" {{ old('country') == 'New Zealand' ? 'selected' : '' }}>New Zealand</option>
            <option value="Thailand" data-phone-code="+66" {{ old('country') == 'Thailand' ? 'selected' : '' }}>Thailand</option>
          </select>

          <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
          <input type="text" name="phone" id="phone-input" placeholder="Phone" required value="{{ old('phone') }}">
          
          <div class="password-field" style="position:relative;">
            <input type="password" name="password" placeholder="Password" required id="password-input">
            <span class="toggle-password" onclick="togglePassword()" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;">
              <i class="fa fa-eye" id="togglePasswordIcon"></i>
            </span>
          </div>
          
          <button class="create">Create account</button>
        </form>

        <p class=" h-have">Have an account? <a href="/login">Log in</a></p>

      </div>

    </div>

  </div>

  <!-- FOOTER -->

  <footer>

    <div class="foot-left">
      <img src="/images/logo.png" alt="" class="foot-image" width="50px">
    </div>

    <div class="foot-right">

      <p id="copyright"></p>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          var year = new Date().getFullYear();
          document.getElementById('copyright').innerHTML = '&copy; ' + year + ' craterExchange. All rights reserved.';
        });
      </script>

      {{-- <div class="socials">
        <a href="#">
          <i class="fa fa-twitter"></i>
        </a>
        <a href="#">
          <i class="fa fa-instagram"></i>
        </a>
        <a href="#">
          <i class="fa fa-telegram"></i>
        </a>
        <a href="#">
          <i class="fa fa-facebook"></i>
        </a>
        <a href="#">
          <i class="fa fa-linkedin"></i>
        </a>
      </div> --}}

    </div>
  </footer>

</body>
<script src="/js/sign-up.js"></script>

</html>