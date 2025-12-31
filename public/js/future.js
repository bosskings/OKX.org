const overlay = document.getElementById('overlay') || {};
const overlay2 = document.getElementById('overlay2') || {};
const amountInput = document.getElementById('amount') || { addEventListener: () => {}, value: '' };
const preview = document.getElementById('preview') || { textContent: '' };
const methodSelect = document.getElementById('method') || { addEventListener: () => {}, value: '' };
const paymentInput = document.getElementById('paymentInput') || { placeholder: '', value: '' };
const copyBtn = document.getElementById('copyBtn') || { addEventListener: () => {}, textContent: '' };




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

methodSelect.addEventListener('change', () => {

  if (methodSelect.value === 'card') {
    paymentInput.placeholder = 'Enter your card details';
    paymentInput.value = '';
  }

  if (methodSelect.value === 'bank') {
    paymentInput.placeholder = 'Enter your bank account number';
    paymentInput.value = '';
  }

  if (methodSelect.value === 'crypto') {
    paymentInput.placeholder = 'Enter your crypto wallet address';
    paymentInput.value = '';
  }

})

copyBtn.addEventListener('click', () => {
  if (!paymentInput.value) {
    alert('Nothing to copy!');
    return;
  }
  navigator.clipboard.writeText(paymentInput.value);
  copyBtn.textContent = 'Copied';


  setTimeout(() => {
    copyBtn.textContent = 'Copy';
  }, 1000);
})


const menuOverlay = document.getElementById('menuOverlay');

function menuOpen() {
  menuOverlay.classList.add('open')
}
function closeMenu() {
  menuOverlay.classList.remove('open')
}


// const data = {
//   overview: [
//     { img: "/images/pf1.jpg", name: "Mine13", long: "+1.40x", pnl: "+95.62%", amount: "+$96,721.15", nums: ["96 / 301", "$167,388.82", "46"] },
//     { img: "/images/pf2.jpg", name: "AlphaX", long: "+2.10x", pnl: "+82.10%", amount: "+$45,882.11", nums: ["120 / 420", "$210,000.22", "51"] },
//     { img: "/images/pf3.jpg", name: "SolKing", long: "+1.90x", pnl: "-72.44%", amount: "+$33,551.18", nums: ["88 / 300", "$98,500.12", "39"] },
//     { img: "/images/pf4.jpg", name: "XrpMaster", long: "+3.10x", pnl: "+130.12%", amount: "+$120,882.55", nums: ["100 / 350", "$199,100.00", "57"] },
//     { img: "/images/pf5.jpg", name: "DogeDude", long: "+1.20x", pnl: "+55.20%", amount: "+$22,221.12", nums: ["68 / 265", "$66,720.00", "30"] },
//     { img: "/images/pf6.jpg", name: "XrpMaster", long: "+3.10x", pnl: "+130.12%", amount: "+$120,882.55", nums: ["100 / 350", "$199,100.00", "57"] },
//   ],
//   pnl_percent: [
//     { img: "/images/pf4.jpg", name: "XrpMaster", long: "+3.10x", pnl: "+130.12%", amount: "+$120,882.55", nums: ["100 / 350", "$199,100.00", "57"] },
//     { img: "/images/pf5.jpg", name: "DogeDude", long: "+1.20x", pnl: "+55.20%", amount: "+$22,221.12", nums: ["68 / 265", "$66,720.00", "30"] }
//   ],
//   pnl: [
//     { img: "/images/pf6.jpg", name: "StablePro", long: "+0.10x", pnl: "+10.21%", amount: "+$8,212.12", nums: ["23 / 102", "$32,119.20", "9"] }
//   ]
// };

// const FILTER_MAPPING = {
//   'Overview': 'overview',
//   'PnL%': 'pnl_percent',
//   'PnL': 'pnl',
//   'Win rate': 'overview',
//   'AUM': 'overview',
//   'No. of copy traders': 'overview',
//   'Copy trader PnL': 'overview'
// };

// function updateRow(rowEl, item) {
//   if (!item) return;

//   const selectors = {
//     img: '.top-left img',
//     name: '.top-text .name',
//     long: '.top-text .long',
//     pnl: '.green',
//     amount: '.amount'
//   };

//   Object.entries(selectors).forEach(([key, selector]) => {
//     const el = rowEl.querySelector(selector);
//     if (el && item[key]) {
//       el[key === 'img' ? 'src' : 'textContent'] = item[key];
//     }
//   });

//   const numsEls = rowEl.querySelectorAll('.nums p');
//   item.nums?.forEach((num, i) => {
//     if (i < numsEls.length) {
//       numsEls[i].textContent = num;
//     }
//   });
// }

// function initializeFilters() {
//   const buttonsContainer = document.querySelector('.main2 .buttons');
//   if (!buttonsContainer) return;

//   const buttons = Array.from(buttonsContainer.querySelectorAll('button'));
//   const rows = Array.from(document.querySelectorAll('.main2 .ch-row'));

//   function applyDataset(key) {
//     let dataset = [...(data[key] || data.overview)];
//     const fallback = data.overview || [];

//     while (dataset.length < rows.length) {
//       dataset.push(fallback[dataset.length % fallback.length]);
//     }

//     rows.forEach((row, idx) => updateRow(row, dataset[idx]));
//   }

//   buttons.forEach(btn => {
//     btn.addEventListener('click', () => {
//       buttons.forEach(b => b.classList.toggle('active', b === btn));
//       const key = FILTER_MAPPING[btn.textContent.trim()] || 'overview';
//       applyDataset(key);
//     });
//   });

//   if (buttons.length) {
//     buttons[0].classList.add('active');
//     applyDataset(FILTER_MAPPING[buttons[0].textContent.trim()] || 'overview');
//   }
// }

function createSparkline(canvas, direction) {
  let data, color;
  if (direction === "up") {
    // Upwards: green color, ascending shape
    color = "#22c55e";

    // Generate an upwards-trending array of random numbers
    data = [2,1,3,2,5,3,7,5,10]
    
  } else {
    // Downwards: red color, descending shape
    color = "#ef4444";
    data = [10,8,5,7,3,2,5,3,1];
  }
  new Chart(canvas, {
    type: "line",
    data: {
      labels: data.map(() => ""),
      datasets: [{
        data,
        borderColor: color,
        borderWidth: 2,
        tension: 0.4,
        pointRadius: 0,
        fill: false
      }]
    },
    options: {
      plugins: { legend: { display: false }, tooltip: { enabled: false } },
      scales: { x: { display: false }, y: { display: false } },
      responsive: false,
      maintainAspectRatio: false
    }
  });
}

document.querySelectorAll('canvas.sparkline').forEach(canvas => {
  if (canvas.closest('.up')) {
    createSparkline(canvas, 'up');
  } else if (canvas.closest('.down')) {
    createSparkline(canvas, 'down');
  }
});



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
        <div><strong>Bank of America:</strong> <br/> <span id="bank1"> 123456789 </span> <a href="#" onclick="copyToClipboard('bank1')">Copy</a></div>
        <div><strong>Chase Bank:</strong><br/> <span id="bank2"> 987654321 </span> <a href="#" onclick="copyToClipboard('bank2')">Copy</a></div>
        <div><strong>Wells Fargo:</strong><br/> <span id="bank3"> 555555555 </span> <a href="#" onclick="copyToClipboard('bank3')">Copy</a></div>
      </div>
    `;
  } else {
    paymentInputGroup.style.display = '';
    html = '';
  }
  detailsArea.innerHTML = html;
}