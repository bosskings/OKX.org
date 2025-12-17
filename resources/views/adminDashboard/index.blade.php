<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>Admin End</title>
    <link rel="icon" href="./images/tesla_logo.png" type="image/x-icon">
    <!-- Favicon-->
    <link rel="stylesheet" href="./admin_assets/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Light Gallery Plugin Css -->
    <link rel="stylesheet" href="./admin_assets/plugins/light-gallery/css/lightgallery.css">
    <link rel="stylesheet" href="./admin_assets/plugins/fullcalendar/fullcalendar.min.css">
    <!-- Custom Css -->
    <link rel="stylesheet" href="./admin_assets/css/style.min.css">

    <meta name="csrf-token" content="">
</head>

<body class="theme-blush">

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="zmdi-hc-spin" src="./images/tesla_logo.png" width="48" height="48" alt="uto">
            </div>
            <p>Please wait...</p>
        </div>
    </div>

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <div class="navbar-brand">
            <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
            <a><img src="./images/tesla_logo.png" width="25" alt="uto"><span class="m-l-10">Titan</span></a>
        </div>
        <div class="menu">
            <ul class="list">
                <li>
                    <div class="user-info">
                        <a class="image"><img src="./images/tesla_logo.png" alt=""></a>
                        <div class="detail">
                            <h4>TeslaFinance</h4>
                            <small>Super Admin</small>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="/change_stocks" class="btn btn-lg btn-secondary" style="color: #e0e0e0">
                        Stock figures
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <section class="content">
        <div class="body_scroll">
            <div class="block-header mb-3">
                <div class="row">
                    <div class="col-lg-7 col-md-6 col-sm-12">
                        <h2>Admin Dashboard</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#" style="color: rgb(120, 120, 120);">Tesla3-admin</a>
                            </li>
                        </ul>
                        <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12">
                        <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button">
                            <i class="zmdi zmdi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">

                    <!-- Example static card as placeholder for user info, since no dynamic PHP allowed -->
                    <div class="col-lg-4 col-md-12">
                        <div class="card mcard_3 ">
                            <div class="body" style="border: 2px solid #28a745;">
                                <h4 class="m-t-10">John Doe</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-muted">johndoe@example.com</p>

                                        <!-- Pending Investments (STATIC EXAMPLE) -->
                                        <div id="statusArea" class="mb-2"
                                            style="background: #fff3cd; border: 1px solid #ffeeba; padding: 10px; border-radius: 5px;">
                                            <h6 style="font-weight:bold; color:#b8860b;">Pending Investments:</h6>
                                            <div style="margin-bottom: 10px;">
                                                <div>
                                                    <span><b>Amount:</b> 5,000.00</span><br>
                                                    <span><b>Stock:</b> AAPL</span><br>
                                                    <span><b>Payment Method:</b> Bank Transfer</span>
                                                    <a href="#">
                                                        <img width="50px" src="./images/payment_proof.png" alt="">
                                                    </a>
                                                </div>
                                                <button class="btn btn-success btn-sm mt-1" onclick="#">
                                                    approve
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Pending Withdrawals (STATIC EXAMPLE) -->
                                        <div id="requestArea" class="mb-2"
                                            style="background:#e8f4fa; border:1px solid #b8e2f2; padding:10px; border-radius: 5px;">
                                            <h6 style="font-weight:bold; color:#03719c;">Pending Withdrawals:</h6>
                                            <div
                                                style="margin-bottom: 8px; background: #fff; padding: 7px 10px; border-radius: 4px; border: 1px solid #e0e0e0;">
                                                <div>
                                                    <span><b>Coin Type:</b> BTC</span><br>
                                                    <span><b>Amount:</b> 1,200.00</span><br>
                                                    <span><b>Wallet Address:</b>
                                                        <span id="withdraw_wallet_1">1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa</span>
                                                        <button class="btn btn-light btn-sm"
                                                            style="padding:1px 8px; font-size:12px;border:1px solid #b3b9be;margin-left:6px;"
                                                            onclick="navigator.clipboard.writeText('1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa'); this.innerText='Copied!'; setTimeout(()=>{this.innerText='Copy';},1300);">
                                                            Copy
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="mt-2 d-flex" style="gap:7px;">
                                                    <div style="margin-left:auto;display:flex;gap:10px;">
                                                        <button class="btn btn-success btn-sm" onclick="#">Approve</button>
                                                        <button class="btn btn-danger btn-sm" onclick="#">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control number-format"
                                                placeholder="Total Balance" id="balance1" value="10,000.00"
                                                oninput="commaFormatInput(this)">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="cursor:pointer;">
                                                    <a style="color: blue; font-size: 12px; font-weight: bold;"
                                                        onclick="#">change balance</a>
                                                </span>
                                            </div>
                                            <div id="resultBalance1"></div>
                                        </div>

                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control number-format"
                                                placeholder="Referral Bonus" id="ref1" value="500.00"
                                                oninput="commaFormatInput(this)">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="cursor:pointer">
                                                    <a style="color: blue; font-size: 12px; font-weight: bold;"
                                                        onclick="#">referral Bonus</a>
                                                </span>
                                            </div>
                                            <div id="resultRef1"></div>
                                        </div>

                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control number-format"
                                                placeholder="Company Bonus" id="company1" value="200.00"
                                                oninput="commaFormatInput(this)">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="cursor:pointer">
                                                    <a style="color: blue; font-size: 12px; font-weight: bold;"
                                                        onclick="#">Company Bonus</a>
                                                </span>
                                            </div>
                                            <div id="resultCompany1"></div>
                                        </div>

                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="NO" id="suspend1"
                                                value="NO">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="cursor:pointer">
                                                    <a style="color: blue; font-size: 12px; font-weight: bold;"
                                                        onclick="#">suspend User</a>
                                                </span>
                                            </div>
                                            <div id="resultSuspend1"></div>
                                        </div>

                                        <div class="d-flex justify-content-center mb-3">
                                            <button type="button" class="btn btn-warning" onclick="#"
                                                style="font-weight:bold; min-width:120px;">
                                                Reset Password
                                            </button>
                                        </div>

                                        <script>
                                            // Formats input with commas for thousands and maintains decimals
                                            function commaFormatInput(el) {
                                                // Remove all non-numeric except periods and commas
                                                let val = el.value.replace(/,/g, '');
                                                // If empty or not a number, blank
                                                if (val === '' || isNaN(val)) {
                                                    el.value = '';
                                                    return;
                                                }
                                                // Split on decimal, format only integer part
                                                let parts = val.split('.');
                                                let intPart = parts[0];
                                                let decPart = parts[1] ? parts[1].slice(0, 2) : '';
                                                intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                                el.value = decPart.length > 0 ? intPart + '.' + decPart : intPart;
                                            }

                                            // On page load, reformat all with .number-format
                                            document.addEventListener('DOMContentLoaded', function () {
                                                document.querySelectorAll('.number-format').forEach(function (input) {
                                                    if (input.value) {
                                                        let val = input.value.replace(/,/g, '');
                                                        if (!isNaN(val) && val !== '') {
                                                            let num = parseFloat(val);
                                                            input.value = num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                                        }
                                                    }
                                                });
                                            });
                                        </script>

                                        <!-- Stock Option History (STATIC EXAMPLE) -->
                                        <div style="max-height: 200px; overflow-y: auto; border: 1px solid #e0e0e0; border-radius: 6px; margin-bottom: 15px;">
                                            <table class="table table-striped mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col">Type</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>CALL</td>
                                                        <td>1,000.00</td>
                                                        <td style="cursor: pointer">
                                                            <span class="badge badge-success">ACTIVE</span>
                                                        </td>
                                                        <td>2024-01-16</td>
                                                    </tr>
                                                    <tr>
                                                        <td>PUT</td>
                                                        <td>2,000.00</td>
                                                        <td style="cursor: pointer">
                                                            <span class="badge badge-warning">INACTIVE</span>
                                                        </td>
                                                        <td>2024-01-18</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted">No transactions found.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- End Stock Option History -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Example - add more cards as needed for placeholder users -->
                    <div class="col-12">
                        <div class="alert alert-info">No users found.</div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="./admin_assets/bundles/libscripts.bundle.js"></script>
    <script src="./admin_assets/bundles/vendorscripts.bundle.js"></script>
    <script src="./admin_assets/plugins/light-gallery/js/lightgallery-all.min.js"></script>
    <script src="./admin_assets/bundles/fullcalendarscripts.bundle.js"></script>
    <script src="./admin_assets/bundles/mainscripts.bundle.js"></script>
    <script src="./admin_assets/js/pages/medias/image-gallery.js"></script>
    <script src="./admin_assets/js/pages/calendar/calendar.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <!-- js to handle admin activities -->
    <script src="./js/adminDash.js"></script>
    

</body>

</html>