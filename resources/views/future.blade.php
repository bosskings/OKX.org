<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FUTURE TRADES</title>
  <link rel="stylesheet" href="/css/future.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Belanosima:wght@400;600;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
</head>

<body>

  @if (session('success'))
    <div id="session-message" class="alert alert-success" style="position:fixed;top:20px;right:20px;z-index:9999;padding:15px 25px;border-radius:8px;background:#e9f8f0;color:#15803d;font-weight:600;box-shadow:0 2px 8px 0 rgba(22,160,133,.14);">
      {{ session('success') }}
    </div>
  @elseif (session('error'))
    <div id="session-message" class="alert alert-danger" style="position:fixed;top:20px;right:20px;z-index:9999;padding:15px 25px;border-radius:8px;background:#fbeaea;color:#b91c1c;font-weight:600;box-shadow:0 2px 8px 0 rgba(220,38,38,.14);">
      {{ session('error') }}
    </div>
  @endif
  <div class="overlay" id="overlay">

    <div class="modal">
    
      <form method="POST" action="{{ route('deposit')}}">
        @csrf

        <div class="close" onclick="toggleModal()"><i class="fa fa-close"></i></div>
        <h2>Deposit</h2>

        <div class="amount-preview" id="preview">$0.00</div>

        <div class="input-group">
          <input type="number" id="amount" name="amount" placeholder="Amount" />
          <select>
            <option>USD</option>
          </select>
        </div>

        <div class="input-group pay-method">
          <select id="method" name="method" onchange="handleMethodChange()">
            <option value="">Select payment method</option>
            <option value="bank">Bank Transfer</option>
            <option value="crypto">Crypto</option>
          </select>
        </div>

        <div id="detailsArea"></div>

        <div class="input-group" id="paymentInputGroup" style="display:none">
          <input type="text" class="" id="paymentInput" placeholder="Enter card details" />
          <button id="copyBtn" class="details-copy">Copy</button>
        </div>

        <button class="deposit-btn">Deposit</button>
      </form>
    </div>
  </div>



  <div class="overlay" id="overlay2">
    <div class="modal">
      <form method="POST" action="{{ route('withdrawRequest') }}">
        @csrf
        
        <div class="close" onclick="toggleModal2()"><i class="fa fa-close"></i></div>
        <h2>Withdraw Funds</h2>

        <div class="amount-preview" id="preview2">$0.00</div>

        <div class="input-group">
          <input type="number" name="amount" id="withdraw_amount" placeholder="Amount" />
        </div>   
        <div class="input-group">
          <select name="method" id="withdrawMethod" onchange="showBankOrCryptoOptions()">
            <option value="">Select withdrawal method</option>
            <option value="bank">Bank Transfer</option>
            <option value="crypto">Crypto</option>
          </select>
        </div>

        <div class="input-group" id="bankOptions" style="display:none;">
          <select name="bank_name" id="bankNameSelect">
            <option value="">Select Bank</option>
            <option value="Chase Bank">Chase Bank</option>
            <option value="Bank of America">Bank of America</option>
            <option value="Wells Fargo">Wells Fargo</option>
          </select>
        </div>

        <div class="input-group" id="cryptoOptions" style="display:none;">
          <select name="crypto_type" id="cryptoTypeSelect">
            <option value="">Select Cryptocurrency</option>
            <option value="Bitcoin">Bitcoin (BTC)</option>
            <option value="Ethereum">Ethereum (ETH)</option>
            <option value="USDT">Tether (USDT)</option>
          </select>
        </div>

        <div class="input-group">
          <input type="text" name="address" class="" id="address" placeholder="Enter card/bank/crypto details" />
          
        </div>

        <button type="submit" class="deposit-btn">Withdraw</button>
      </form>
    </div>
  </div>


  <div class="menu-overlay" id="menuOverlay">
    <button onclick="closeMenu()"><i class="fa fa-close"></i></button>
    <a href="/">HOME</a>
    <a href="/spot">SPOT TRADE</a>
    <a href="/futures">FUTURE TRADE</a>
    <a href="/logout">Logout</a>
  </div>


  <!-- NAVIGATION -->

  <nav>
    <div class="nav-left">
      <a href="/"><img src="/images/logo.png" alt="Logo" width="50px"></a>
      <a class="abt" href="/future">Future Trades <i class="fa fa-angle-down"></i></a>
      <a class="copy" href="/spot">Spot Trades <i class="fa fa-angle-down"></i></a>
    </div>

    <div style="display: flex; gap: 20px; align-items: center;">
      <div class="nav-right">
        <a href="#" class="deposit open-modal" onclick="toggleModal()">Deposit</a>
        <a href="#" class="deposit open-modal" onclick="toggleModal2()">Withdraw</a>
        {{-- <i class="fa fa-user"></i>
        <i class="fa fa-bell"></i>
        <i class="fa fa-question-circle-o"></i> --}}
      </div>

      <button onclick="menuOpen()" class="menu"><i class="fa fa-bars"></i></button>
    </div>
  </nav>

  <!-- MAIN -->

  <div class="future-main">

    <h2 class="market">Future Trade MarketPlace</h2>

    <p class="est">Est total assets<span>{{ number_format(Auth::user()->total_assets ?? 0, 2) }} USD</span></p>

    <div class="options">
      <a href="{{ route('dashboard')}}" class="my">
        <i class="fa fa-arrow-left" style="margin-right: 6px"></i> Dashboard
      </a>
    </div>

    <!-- PICKS -->

    <div class="main2">

      <div class="top-links">
        <a class="m-link" href="#">Smart picks</a>
        <!-- <a class="m-link" href="#">Future copy trading</a>
        <a class="m-link" href="#">Spot copy trading</a>
        <a class="m-link" href="#">Bots</a> -->
      </div>

      <div class="search-traders">
        <i class="fa fa-search"></i>
        <input 
          type="text" 
          id="searchTraderInput" 
          placeholder="Search traders"
          onkeyup="filterTraders()" 
          autocomplete="off"
        >
      </div>

      <div class="buttons">
        <button>Overview</button>
        <button>PnL%</button>
        <button>PnL</button>
        <button>Win rate</button>
      </div>

      <div class="charts" id="chartsContainer"></div>

      <div class="charts" id="charts">
        @foreach($traders as $trader)
          <div 
            class="ch-row" 
            data-trader-name="{{ strtolower($trader->name) }}"
          >
            <div class="ch-main-left">
              <div class="top-left">
                <img src="{{ isset($trader->profile_pic) ? asset('uploads/' . $trader->profile_pic) : '/images/default-profile.png' }}" alt="Profile image">
                <div class="top-text">
                  <p class="name">{{ $trader->name }}</p>
                  <p class="long">+{{ $trader->leading_trades ?? '+1.00x' }}x</p>
                </div>
                <span style="color: #21c26c; margin-left: -10px; font-size: 18px; vertical-align: middle;" title="Verified">
                  <i class="fa fa-check-circle"></i>
                </span>
              </div>
              <div>
                <p class="lead">Lead trader 90D PnL</p>
                @php
                  // decide class color based on profit sign
                  $profitValue = floatval(preg_replace('/[^\d\.\-]/', '', $trader->profit_percentage));
                  $profitClass = $profitValue < 0 ? 'red' : 'green';
                @endphp
                <h2 class="{{ $profitClass }}">{{ $trader->profit_percentage }}</h2>
                <p class="amount">{{ $trader->amount_made }}</p>
              </div>
              <div class="details">
                <p class="gray">Copy</p>
                <p class="gray">AUM</p>
                <p class="gray">Days leading trades</p>
              </div>
            </div>
            <div class="ch-main-right">
              <a href="/futureDetails?id={{ $trader->id }}">
                <button class="copy-btn">Copy</button>
              </a>
              <canvas class="sparkline {{ $trader->direction }}" ></canvas>
              <div class="nums">
                <p>{{ $trader->copies }} / <span>{{ $trader->aum }}</span></p>
                <p>{{ $trader->amount_made }}</p>
                <p>{{ $trader->leading_trades }}</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <script>
        function filterTraders() {
          const input = document.getElementById('searchTraderInput');
          const filter = input.value.trim().toLowerCase();
          const traderRows = document.querySelectorAll('.charts#charts .ch-row');

          if (!filter) {
            // If search empty, show all
            traderRows.forEach(row => row.style.display = "");
            return;
          }

          // Create array with row and name for sorting
          let rowsArr = Array.from(traderRows).map(row => {
            const name = row.getAttribute('data-trader-name') || '';
            return { row, name };
          });

          // Filter and sort: names starting with filter first, then containing filter
          let matched = [];
          let others = [];
          rowsArr.forEach(({ row, name }) => {
            if (name.startsWith(filter)) {
              matched.push(row);
            } else if (name.includes(filter)) {
              others.push(row);
            } else {
              row.style.display = 'none';
            }
          });

          // Reorder: show matched first, then others
          const charts = document.getElementById('charts');
          // Remove all rows first
          rowsArr.forEach(({ row }) => charts.removeChild(row));
          // Append in the new order and display
          matched.concat(others).forEach(row => {
            row.style.display = "";
            charts.appendChild(row);
          });
        }
      </script>
        


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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/js/future.js"></script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
  var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
  (function(){
  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
  s1.async=true;
  s1.src='https://embed.tawk.to/694c2852420bc819787f5259/1jd8nr0qg';
  s1.charset='UTF-8';
  s1.setAttribute('crossorigin','*');
  s0.parentNode.insertBefore(s1,s0);
  })();
</script>
<!--End of Tawk.to Script-->


</html>