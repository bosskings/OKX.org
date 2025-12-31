<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>Admin End</title>
    <link rel="icon" href="./images/logo.png" type="image/x-icon">
    <!-- Favicon-->
    <link rel="stylesheet" href="./admin_assets/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Light Gallery Plugin Css -->
    <link rel="stylesheet" href="./admin_assets/plugins/light-gallery/css/lightgallery.css">
    <link rel="stylesheet" href="./admin_assets/plugins/fullcalendar/fullcalendar.min.css">
    <!-- Custom Css -->
    <link rel="stylesheet" href="./admin_assets/css/style.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="theme-blush">

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30">
                <img class="zmdi-hc-spin" src="./images/logo.png" width="48" height="48" alt="uto">
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
            <a><img src="./images/logo.png" width="25" alt="uto"><span class="m-l-10">Crater</span></a>
        </div>
        <div class="menu">
            <ul class="list">
                <li>
                    <div class="user-info">
                        <a class="image"><img src="./images/logo.png" alt=""></a>
                        <div class="detail">
                            <h4>Craterxchange</h4>
                            <small>Super Admin</small>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="/createTraders" class="btn btn-lg btn-secondary" style="color: #e0e0e0">
                        Create Traders
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
                                <a href="#" style="color: rgb(120, 120, 120);">Craterxchange-admin</a>
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
                    
                    {{-- <pre>{{ print_r($pendingDepositTransactions) }}</pre> --}}

                    <!-- Example static card as placeholder for user info, since no dynamic PHP allowed -->
                    @if(isset($users) && count($users) > 0)
                        @foreach($users as $user)
                            <div class="col-lg-4 col-md-12">
                                <div class="card mcard_3">
                                    <div class="body" style="border: 2px solid #28a745;">
                                        <h4 class="m-t-10">{{ $user->email ?? '-' }}</h4>
                                        <div class="row">
                                            <div class="col-12">


                                                {{-- Show pending DEPOSIT transactions for this user --}}
                                                @php
                                                    // Controller provides $pendingDepositTransactions as a collection of all PENDING DEPOSITs
                                                    // We need to filter only those for this user
                                                    $userPendingDeposits = $pendingDepositTransactions->where('user_id', $user->id);
                                                @endphp
                                                @if($userPendingDeposits->count() > 0)
                                                    <div id="statusArea" class="mb-2"
                                                        style="background: #fff3cd; border: 1px solid #ffeeba; padding: 10px; border-radius: 5px;">
                                                        <h6 style="font-weight:bold; color:#b8860b;">Pending Investments:</h6>
                                                        @foreach($userPendingDeposits as $transaction)
                                                            <div style="margin-bottom: 10px;">
                                                                <div>
                                                                    <span><b>Amount:</b> {{ number_format($transaction->amount ?? 0, 2) }}</span><br>
                                                                    <span><b>Method:</b> {{ $transaction->method ?? '-' }}</span><br>
                                                                </div>
                                                                <button class="btn btn-success btn-sm mt-1" onclick="approve_investment({{ $user->id }}, {{ $transaction->amount }}, {{ $transaction->id }})">
                                                                    Approve
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                {{-- Show latest PENDING WITHDRAW transaction for this user --}}
                                                @if(isset($userLatestPendingWithdraw[$user->id]) && $userLatestPendingWithdraw[$user->id])
                                                    @php
                                                        $withdrawal = $userLatestPendingWithdraw[$user->id];
                                                    @endphp
                                                    <div id="requestArea" class="mb-2"
                                                        style="background:#e8f4fa; border:1px solid #b8e2f2; padding:10px; border-radius: 5px;">
                                                        <h6 style="font-weight:bold; color:#03719c;">Pending Withdrawal:</h6>
                                                        <div
                                                            style="margin-bottom: 8px; background: #fff; padding: 7px 10px; border-radius: 4px; border: 1px solid #e0e0e0;">
                                                            <div>
                                                                <span><b>Coin Type:</b> {{ $withdrawal->method ?? '-' }}</span><br>
                                                                <span><b>Amount:</b> {{ number_format($withdrawal->amount ?? 0, 2) }}</span><br>
                                                                <span><b>Wallet Address:</b>
                                                                    <span id="withdraw_wallet_{{ $withdrawal->id }}">{{ $withdrawal->address ?? '-' }}</span>
                                                                    @if(!empty($withdrawal->address))
                                                                        <button class="btn btn-light btn-sm"
                                                                            style="padding:1px 8px; font-size:12px;border:1px solid #b3b9be;margin-left:6px;"
                                                                            onclick="navigator.clipboard.writeText('{{ $withdrawal->address }}'); this.innerText='Copied!'; setTimeout(()=>{this.innerText='Copy';},1300);">
                                                                            Copy
                                                                        </button>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <div class="mt-2 d-flex" style="gap:7px;">
                                                                <div style="margin-left:auto;display:flex;gap:10px;">
                                                                    <button class="btn btn-success btn-sm" onclick="approveWithdrawal('SUCCESS',{{ $user->id }}, {{ $withdrawal->amount }}, {{ $withdrawal->id }})">Approve</button>
                                                                    <button class="btn btn-danger btn-sm" onclick="approveWithdrawal('DECLINED',{{ $user->id }}, {{ $withdrawal->amount }}, {{ $withdrawal->id }})">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control number-format"
                                                        placeholder="Total Balance" id="balance_{{ $user->id }}" value="{{ number_format($user->available_balance ?? 0, 2) }}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" style="cursor:pointer;">
                                                            <a style="color: blue; font-size: 12px; font-weight: bold;"
                                                                onclick="changeBalance({{ $user->id }})">change balance</a>
                                                        </span>
                                                    </div>
                                                    <div id="resultBalance{{ $user->id }}"></div>
                                                </div>

                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control number-format"
                                                        placeholder="Referral Bonus" id="todaysPnl_{{ $user->id }}" value="{{ number_format($user->todays_pnl ?? 0, 2) }}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" style="cursor:pointer">
                                                            <a style="color: blue; font-size: 12px; font-weight: bold;"
                                                                onclick="todaysPnl({{ $user->id }})">Todays PNL</a>
                                                        </span>
                                                    </div>
                                                    <div id="resultPnl{{ $user->id }}"></div>
                                                </div>

                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control number-format"
                                                        placeholder="Company Bonus" id="assets{{ $user->id }}" value="{{ number_format($user->total_assets ?? 0, 2) }}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" style="cursor:pointer">
                                                            <a style="color: blue; font-size: 12px; font-weight: bold;"
                                                                onclick="totalAssets({{ $user->id }})">Total Assets</a>
                                                        </span>
                                                    </div>
                                                    <div id="resultAssets{{ $user->id }}"></div>
                                                </div>


                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" placeholder="PENDING" id="verify{{ $user->id }}"
                                                        value="{{ $user->status}}" list="userStatusOptions{{ $user->id }}">
                                                    <datalist id="userStatusOptions{{ $user->id }}">
                                                        <option value="APPROVED">
                                                        <option value="PENDING">
                                                    </datalist>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" style="cursor:pointer">
                                                            <a style="color: blue; font-size: 12px; font-weight: bold;"
                                                                onclick="verifyUser({{$user->id}})">Verify User</a>
                                                        </span>
                                                    </div>
                                                    <div id="resultVerify{{ $user->id }}"></div>
                                                </div>


                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" placeholder="NO" id="suspend{{ $user->id }}"
                                                        value="{{ $user->suspended}}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" style="cursor:pointer">
                                                            <a style="color: blue; font-size: 12px; font-weight: bold;"
                                                                onclick="suspend_user({{$user->id}})">suspend User</a>
                                                        </span>
                                                    </div>
                                                    <div id="resultSuspend{{ $user->id }}"></div>
                                                </div>


                                                {{-- verification pictures --}}
                                                @if(!empty($user->pic_front) || !empty($user->pic_back))
                                                    <div class="mb-3">
                                                        <div class="d-flex flex-row align-items-center justify-content-between">
                                                            @if(!empty($user->pic_front))
                                                                <div class="text-center" style="flex:1;">
                                                                    <div style="font-size:12px;">Front</div>
                                                                    <a href="{{ asset($user->pic_front) }}" target="_blank">
                                                                        <img src="{{ asset($user->pic_front) }}" alt="Pic Front" style="max-width:80px; max-height:80px; border-radius:4px; border:1px solid #ddd;">
                                                                    </a>
                                                                </div>
                                                            @else
                                                                <div style="flex:1;"></div>
                                                            @endif
                                                            @if(!empty($user->pic_back))
                                                                <div class="text-center" style="flex:1;">
                                                                    <div style="font-size:12px;">Back</div>
                                                                    <a href="{{ asset($user->pic_back) }}" target="_blank">
                                                                        <img src="{{ asset($user->pic_back) }}" alt="Pic Back" style="max-width:80px; max-height:80px; border-radius:4px; border:1px solid #ddd;">
                                                                    </a>
                                                                </div>
                                                            @else
                                                                <div style="flex:1;"></div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif




                                                <div class="d-flex justify-content-center mb-3">
                                                    <button type="button" class="btn btn-warning" onclick="reset_password({{$user->id}})"
                                                        style="font-weight:bold; min-width:120px;">
                                                        Reset Password
                                                    </button>
                                                </div>

                                                <!-- Stock Option History (TRADES) -->
                                                <div style="max-height: 200px; overflow-y: auto; border: 1px solid #e0e0e0; border-radius: 6px; margin-bottom: 15px;">
                                                    <table class="table table-striped mb-0">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th scope="col">Type</th>
                                                                <th scope="col">Amount</th>
                                                                <th scope="col">date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $trades = $userTrades[$user->id] ?? collect();
                                                            @endphp
                                                            @if($trades->count() > 0)
                                                                @foreach($trades as $trade)
                                                                    <tr>
                                                                        <td>{{ $trade->type ?? '-' }}</td>
                                                                        <td>{{ number_format($trade->amount ?? 0, 2) }}</td>
                                                                        <td>{{ $trade->created_at ? \Carbon\Carbon::parse($trade->created_at)->toDateString() : '-' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="5" class="text-center text-muted">No transactions found.</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- End Stock Option History -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-info">No users found.</div>
                        </div>
                    @endif

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