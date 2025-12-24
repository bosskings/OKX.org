<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Belanosima:wght@400;600;700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="/css/dashboard.css">
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



  <div class="overlay2" id="overlay2">
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
    <a href="{{ route('home') }}">HOME</a>
    <a href="{{ route('spot') }}">SPOT TRADE</a>
    <a href="{{ route('futures') }}">FUTURE TRADE</a>
    <a href="/logout">Logout</a>
  </div>

  <!-- NAVIGATION -->

  <nav>
    <div class="nav-left">
      <a href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo" width="50px"></a>
      <a class="abt" href="{{ route('futures') }}">Future Trades <i class="fa fa-angle-down"></i></a>
      <a class="copy" href="{{ route('spot') }}">Spot Trades <i class="fa fa-angle-down"></i></a>
    </div>

    <div style="display: flex; gap: 20px; align-items: center;">
      {{-- <div class="nav-right">
        <i class="fa fa-search"></i>
        <i class="fa fa-user"></i>
        <i class="fa fa-bell"></i>
        <i class="fa fa-question-circle-o"></i>
      </div> --}}

      <div class="balance-options">
        <button class="open-modal" onclick="toggleModal2()">Withdraw</button>
        <button class="deposit open-modal" onclick="toggleModal()">Deposit</button>
      </div>

      <button onclick="menuOpen()" class="menu"><i class="fa fa-bars"></i></button>
    </div>
  </nav>

  <!-- MAIN DASHBOARD -->

  <div class="dash-main">

    <p class="overview">Overview</p>

    <div class="user-details">

      <div class="user-main user">
        <div class="user-main-left">
          <img src="{{ asset('images/dash-user.png') }}" alt="User image" data-aos="zoom-out">
        </div>
        <div class="user-main-text">
          <p class="text-mail">{{ $user->email }}</p>
          <p class="gray">780856055025927551</p>
        </div>
      </div>

      <div class="user-email user-r">

        <p class="gray">Email</p>
        <p class="main-e">{{ $user->email }}</p>

      </div>

      <div class="user-verification user-r">
        <p class="gray">Identity verification <i class="fa fa-angle-right"></i></p>
        <a href="#">
          @if(isset($user->status) && $user->status === 'APPROVED')
            <span style="color:green; font-weight:bold;">
              Verified <i class="fa fa-check-circle"></i>
            </span>
          @else
            <span style="color:#ff6b6b; font-weight:bold;">
              Unverified
            </span>
          @endif
        </a>
      </div>

      <div class="user-country user-r">
        <p class="gray">Country/Region <i class=" fa fa-angle-right"></i></p>
        <p class="country-text">{{ $user->country ?? 'N/A' }}</p>
      </div>

      <div class="user-trading user-r">
        <p class="gray">Trading fee tier <i class="fa fa-angle-right"></i></p>
        <a href="#" class="regular">Regular user</a>
      </div>

    </div>

    <div class="dash-bottom">
      <div class="dash-left">

        <div class="balance">
          <p class="estimated">Estimated total value <i id="toggleEye" class="fa fa-eye"></i></p>
          @if(isset($user->status) && $user->status === 'APPROVED')
            <h2 class="money" id="money">{{ number_format($user->available_balance ?? $user->balance ?? 0, 2) }} <span class="currency">USD</span></h2>
          @else
            <h2 class="money" id="money" style="color: #ccc; text-decoration: line-through;">
              {{ number_format($user->available_balance ?? $user->balance ?? 0, 2) }} <span class="currency">USD</span>
            </h2>
          @endif
          <p class="today"><span>Today's PnL </span> ${{$user->todays_pnl}}</p>
        </div>

        <div id="tv_chart_container" style="height:420px; width:100%;"></div>
        
        <div class="dl-top">
          <div>
            <h2>Help us secure your account</h2>
            <p class="gray2">Verify your identity</p>
          </div>

          <div class="smile">
            <div class="vyi">
              <i class="fa fa-smile-o"></i>
              <div>
                <p>verification After first deposit</p>
                <p class="gray2">Complete verification for enhanced security</p>
              </div>
            </div>
            @if(isset($user->status) && $user->status === 'APPROVED')
              <span style="color:green; font-weight:bold;">
                Verified <i class="fa fa-check-circle"></i>
              </span>
            @else
              <span style="color:#ff6b6b; font-weight:bold;">
                Unverified
              </span>
            @endif
          </div>
        </div>

        <div class="dl-bottom">
          <h2>Today's crypto prices</h2>
          <div class="trends">
            <button data-filter="favorites" class="active">Favorites</button>
          </div>

          <div class="crypto-table" style="height:70vh">

            <!-- TradingView Widget BEGIN -->
            <div class="tradingview-widget-container">
              <div class="tradingview-widget-container__widget"></div>
              <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/markets/" rel="noopener nofollow" target="_blank"><span class="blue-text">Market summary</span></a><span class="trademark"> by TradingView</span></div>
              <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-quotes.js" async>
              {
              "colorTheme": "dark",
              "locale": "en",
              "largeChartUrl": "",
              "isTransparent": false,
              "showSymbolLogo": true,
              "backgroundColor": "#0F0F0F",
              "support_host": "https://www.tradingview.com",
              "width": "100%",
              "height": "100%",
              "symbolsGroups": [
                
                {
                  "name": "Futures",
                  "symbols": [
                    {
                      "name": "BINANCE:BTCUSDT",
                      "displayName": "BTC"
                    },
                    {
                      "name": "BINANCE:ETHUSDT",
                      "displayName": "ETH"
                    },
                    {
                      "name": "BINANCE:SOLUSDT",
                      "displayName": "SOL"
                    },
                    {
                      "name": "BINANCE:BNBUSDT",
                      "displayName": "XRP"
                    },
                    {
                      "name": "BINANCE:BNBUSDT",
                      "displayName": "BNB"
                    },
                    {
                      "name": "BINANCE:LTCUSDT",
                      "displayName": "LTC"
                    }
                  ]
                },
                {
                  "name": "Bonds",
                  "symbols": [
                    {
                      "name": "BINANCE:BTCUSDT",
                      "displayName": "BTC"
                    },
                    {
                      "name": "BINANCE:ETHUSDT",
                      "displayName": "ETH"
                    },
                    {
                      "name": "BINANCE:SOLUSDT",
                      "displayName": "SOL"
                    },
                    {
                      "name": "BINANCE:BNBUSDT",
                      "displayName": "XRP"
                    },
                    {
                      "name": "BINANCE:BNBUSDT",
                      "displayName": "BNB"
                    },
                    {
                      "name": "BINANCE:LTCUSDT",
                      "displayName": "LTC"
                    }
                  ]
                },
                {
                  "name": "Forex",
                  "symbols": [
                    {
                      "name": "BINANCE:BTCUSDT",
                      "displayName": "BTC"
                    },
                    {
                      "name": "BINANCE:ETHUSDT",
                      "displayName": "ETH"
                    },
                    {
                      "name": "BINANCE:SOLUSDT",
                      "displayName": "SOL"
                    },
                    {
                      "name": "BINANCE:BNBUSDT",
                      "displayName": "XRP"
                    },
                    {
                      "name": "BINANCE:BNBUSDT",
                      "displayName": "BNB"
                    },
                    {
                      "name": "BINANCE:LTCUSDT",
                      "displayName": "LTC"
                    }
                  ]
                }
              ]
            }
              </script>
            </div>
            <!-- TradingView Widget END -->

          </div>
        </div>
      </div>

      <div class="dash-right">
        <h2>Transaction History</h2>
        
        @if(isset($no_transactions_message))
          <div class="ann-row">
            <span style="color:#888;">{{ $no_transactions_message }}</span>
          </div>
        @elseif(isset($transactions) && count($transactions) > 0)
          @foreach($transactions as $transaction)
            <div class="ann-row" style="display: flex; align-items: center; flex-wrap: wrap; margin-bottom:8px; font-size:10px;">
              <span style="border-left:1px solid #ddd; border-right:1px solid #ddd; padding: 0 8px; font-size:10px;">#{{ $transaction->id }}</span>
              <span style="border-left:1px solid #ddd; border-right:1px solid #ddd; padding: 0 8px; font-size:10px;">{{ $transaction->transaction_type }}</span>
              <span style="border-left:1px solid #ddd; border-right:1px solid #ddd; padding: 0 8px; font-size:10px;">${{ number_format($transaction->amount, 2) }}</span>
              <span style="border-left:1px solid #ddd; border-right:1px solid #ddd; padding: 0 8px; font-size:10px;">
                <span style="color:
                  @if(strtoupper($transaction->status) === 'SUCCESS')green
                  @elseif(strtoupper($transaction->status) === 'PENDING')orange
                  @elseif(strtoupper($transaction->status) === 'DECLINED')#ff6b6b
                  @else #666
                  @endif;
                  font-weight: bold; font-size:10px;">
                  {{ strtoupper($transaction->status) }}
                </span>
              </span>
              <span style="border-left:1px solid #ddd; border-right:1px solid #ddd; padding: 0 8px; font-size:10px;">{{ $transaction->method ?? '-' }}</span>
              <span style="padding: 0 4px; font-size:9px; color:#888;">{{ \Carbon\Carbon::parse($transaction->created_at)->format('m/d H:i') }}</span>
            </div>
          @endforeach
        @else
          <div class="ann-row">
            <span style="color:#888;">No transactions have occurred yet.</span>
          </div>
        @endif

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
        <a href="https://twitter.com/" target="_blank">
          <i class="fa fa-twitter"></i>
        </a>
        <a href="https://instagram.com/" target="_blank">
          <i class="fa fa-instagram"></i>
        </a>
        <a href="https://telegram.org/" target="_blank">
          <i class="fa fa-telegram"></i>
        </a>
        <a href="https://facebook.com/" target="_blank">
          <i class="fa fa-facebook"></i>
        </a>
        <a href="https://linkedin.com/" target="_blank">
          <i class="fa fa-linkedin"></i>
        </a>
      </div> --}}
    </div>
  </footer>

</body>
<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
<script src="/js/dashboard.js"></script>

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