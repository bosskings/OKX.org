<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="/css/login.css">
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
      <a href="/"><img src="/images/logo.png" alt="Logo" width="50px"></a>
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

  <div class="login">

    <div class="login-left">
      <h2>Trade with confidence</h2>
      <p>We don't lend out customer funds, which is <br> verified through our regularly published Proof of <br> Reserves
        audits.
      </p>
      <img src="/images/log-in.webp" alt="">
    </div>

    <div class="login-right">

      <div class="user-inputs">

        <h2>Log in</h2>

        <div class="options">
          <button type="button" onclick="phone()" id="phoneOption">Phone</button>
          <button type="button" onclick="email()" id="emailOption">Email</button>
        </div>
        
        <form action="{{ route('login') }}" method="POST">
          @csrf
          
          @if(session('success'))
            <div id="message" style="background: #ddffdd; color: #006600; border: 1px solid #009900; padding: 10px; margin-bottom: 15px; border-radius: 5px; text-align: center;">
                {{ session('success') }}
            </div>
          @endif
          @if(session('error'))
            <div id="message" style="background: #ffdddd; color: #c00; border: 1px solid #c00; padding: 10px; margin-bottom: 15px; border-radius: 5px; text-align: center;">
                {{ session('error') }}
            </div>
          @endif

          <input id="userInput" type="email" name="email" placeholder="example@gmail.com" aria-label="Email address" required value="{{ old('email') }}">

          <div style="position: relative;">
            <input type="password" name="password" id="passwordInput" placeholder="**********" required style="padding-right: 40px;">
            <span onclick="togglePasswordVisibility()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
              <i class="fa fa-eye" id="togglePasswordIcon"></i>
            </span>
          </div>
          <button class="next" id="nextBtn" type="submit">Next</button>
        </form>

        <p class="d-have">Don't have an account? <a href="/sign-up">Sign up</a></p>

        <div class="continue">
          <div class="line"></div>
          <p> Or continue with </p>
          <div class="line"></div>
        </div>

        <div class="other-options">
          <div class="other-opt">
            <i class="fa fa-key"></i>
            <p>Passkey</p>
          </div>
          <div class="other-opt">
            <img src="/images/google.png" alt="">
            <p>Google</p>
          </div>
          <div class="other-opt">
            <img src="/images/apple.png" alt="">
            <p>Apple</p>
          </div>
          <div class="other-opt">
            <img src="/images/telegram.png" alt="">
            <p>Telegram</p>
          </div>
        </div>

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
<script src="/js/login.js"></script>

</html>