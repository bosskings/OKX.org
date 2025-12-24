const overlay = document.getElementById('overlay');
const overlay2 = document.getElementById('overlay2');
const paymentInput = document.getElementById('paymentInput');
const paymentInput2 = document.getElementById('paymentInput2');
const amountInput = document.getElementById('amount');
const withdraw_amount = document.getElementById('withdraw_amount');
const preview = document.getElementById('preview');
const preview2 = document.getElementById('preview2');
const copyBtn = document.getElementById('copyBtn');
const copyBtn2 = document.getElementById('copyBtn2');




function toggleModal() {
  overlay.classList.toggle('modalShow');
}

function toggleModal2() {
  overlay2.classList.toggle('modalShow');
}


amountInput.addEventListener('input', () => {
  preview.textContent = amountInput.value
    ? `$${amountInput.value}`
    : '$0.00';
});

withdraw_amount.addEventListener('input', () => {
  preview2.textContent = withdraw_amount.value
    ? `$${withdraw_amount.value}`
    : '$0.00';
});

copyBtn.addEventListener('click', () => {
  navigator.clipboard.writeText(paymentInput.value);
  copyBtn.textContent = 'Copied';


  setTimeout(() => {
    copyBtn.textContent = 'Copy';
  }, 1000);
})

  // copyBtn2.addEventListener('click', () => {
  //   if (!paymentInput2.value) {
  //     alert('Nothing to copy!');
  //     return;
  //   }
  //   navigator.clipboard.writeText(paymentInput2.value);
  //   copyBtn2.textContent = 'Copied';


  //   setTimeout(() => {
  //     copyBtn2.textContent = 'Copy';
  //   }, 1000);
  // })


const menuOverlay = document.getElementById('menuOverlay');

function menuOpen() {
  menuOverlay.classList.add('open')
}
function closeMenu() {
  menuOverlay.classList.remove('open')
}

let isHidden = false;
let money = document.getElementById("money");
let toggleBtn = document.getElementById("toggleEye");

let originalAmount = money.textContent;

toggleBtn.addEventListener("click", function () {
  if (isHidden === false) {
    money.textContent = "*****";
    isHidden = true;
  } else {
    money.textContent = originalAmount;
    isHidden = false;
  }
});

const buttons = document.querySelectorAll(".trends button");
const rows = document.querySelectorAll(".crypto-row");

buttons.forEach(btn => {
  btn.addEventListener("click", () => {
    buttons.forEach(b => b.classList.remove("active"));

    btn.classList.add("active");

    const filter = btn.dataset.filter;

    if (filter === "favorites") {
      rows.forEach(row => row.style.display = "flex");
      resetImages();
      return;
    }

    rows.forEach((row, index) => {
      if (index > 3) {
        row.style.display = "none";
      } else {
        row.style.display = "flex";
      }
    });

    changeImages(filter);
  });
});

const iconMap = {
  top: {
    BTC: "/images/btc.png",
    ETH: "/images/eth.png",
    SOL: "/images/sol.png",
    DOGE: "/images/doge.png",
    XRP: "/images/xrp.png",
    USDT: "/images/usdt.png",
  },

  hot: {
    BTC: "/images/sol.png",
    ETH: "/images/eth.png",
    SOL: "/images/btc.png",
    DOGE: "/images/doge.png",
    XRP: "/images/xrp.png",
    USDT: "/images/usdt.png"
  },

  gainers: {
    BTC: "/images/eth.png",
    ETH: "/images/doge.png",
    SOL: "/images/sol.png",
    DOGE: "/images/btc.png",
    XRP: "/images/xrp.png",
    USDT: "/images/usdt.png"
  },

  new: {
    BTC: "/images/usdt.png",
    ETH: "/images/eth.png",
    SOL: "/images/btc.png",
    DOGE: "/images/doge.png",
    XRP: "/images/xrp.png",
    USDT: "/images/usdt.png"
  }
};

function changeImages(filter) {
  rows.forEach(row => {
    const name = row.querySelector(".name").textContent.replace("/USD", "");
    const img = row.querySelector("img.icon");

    if (iconMap[filter] && iconMap[filter][name]) {
      img.src = iconMap[filter][name];
    }
  });
}

function resetImages() {
  const originalIcons = {
    BTC: "/images/btc.png",
    ETH: "/images/eth.png",
    SOL: "/images/sol.png",
    DOGE: "/images/doge.png",
    XRP: "/images/xrp.png",
    USDT: "/images/usdt.png"
  };

  rows.forEach(row => {
    const name = row.querySelector(".name").textContent.replace("/USD", "");
    const img = row.querySelector("img.icon");

    if (img && originalIcons[name]) {
      img.src = originalIcons[name];
    }
  });
}

if (typeof TradingView !== 'undefined') {
  new TradingView.widget({
    autosize: true,
    symbol: "BINANCE:BTCUSDT",
    interval: "60",
    container_id: "tv_chart_container",
    timezone: "Etc/UTC",
    theme: "dark",
    style: "1",
    locale: "en",
    toolbar_bg: "#222",
    enable_publishing: false,
    allow_symbol_change: true,
    hide_side_toolbar: false
  });
}




// for deposit selection 


function handleMethodChange() {
  const method = document.getElementById('method').value;
  const detailsArea = document.getElementById('detailsArea');
  const paymentInputGroup = document.getElementById('paymentInputGroup');
  let html = '';
  if (method === 'crypto') {
    paymentInputGroup.style.display = 'none';
    html = `
      <div class="wallet-addresses" >
        <div><strong>BTC:</strong> <br> <span id="btc-address">bc1qhgudn7vl0rwks55xphayl9qyd05lxxxf5scqpq</span> <a href="#" onclick="copyToClipboard('btc-address')">Copy</a></div>
        <div><strong>ETH:</strong> <br> <span id="eth-address">0xea978943B493E7284F5bE85294c44976C2a7Ed7c</span> <a href="#" onclick="copyToClipboard('eth-address')">Copy</a></div>
        <div><strong>USDT (TRC20):</strong><br/> <span id="usdt-address">TQw1Tf4zogp19aDMt1HgVcrTe3nXTwWmHN</span> <a href="#" onclick="copyToClipboard('usdt-address')">Copy</a></div>
      </div>
    `;
  } else if (method === 'bank') {
    paymentInputGroup.style.display = 'none';
    html = `
      <div class="wallet-addresses">
        <div><strong>Bank of America:</strong> <br/> <span id="bank1"> 123456789 </span> <button onclick="copyToClipboard('bank1')">Copy</button></div>
        <div><strong>Chase Bank:</strong><br/> <span id="bank2"> 987654321 </span> <button onclick="copyToClipboard('bank2')">Copy</button></div>
        <div><strong>Wells Fargo:</strong><br/> <span id="bank3"> 555555555 </span> <button onclick="copyToClipboard('bank3')">Copy</button></div>
      </div>
    `;
  } else {
    paymentInputGroup.style.display = '';
    html = '';
  }
  detailsArea.innerHTML = html;
}

function copyToClipboard(id) {
  const el = document.getElementById(id);
  const value = el ? el.textContent : '';
  if (navigator.clipboard) {
    navigator.clipboard.writeText(value);
  } else {
    // fallback
    const tmp = document.createElement('textarea');
    tmp.value = value;
    document.body.appendChild(tmp);
    tmp.select();
    document.execCommand('copy');
    document.body.removeChild(tmp);
  }
  alert('Copied!');
}



// for error messages

document.addEventListener("DOMContentLoaded", function() {
  const msg = document.getElementById('session-message');
  if (msg) {
    setTimeout(function() {
      msg.style.transition = 'opacity 0.4s';
      msg.style.opacity = 0;
      setTimeout(() => msg.remove(), 400);
    }, 5000);
  }
});


function showBankOrCryptoOptions() {
  var method = document.getElementById('withdrawMethod').value;
  document.getElementById('bankOptions').style.display = (method === "bank") ? "block" : "none";
  document.getElementById('cryptoOptions').style.display = (method === "crypto") ? "block" : "none";
}