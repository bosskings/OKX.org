<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <title>Admin End</title>
        <link rel="icon" href="images/logo.png" type="image/x-icon">
        <!-- Favicon-->
        <link rel="stylesheet" href="admin_assets/plugins/bootstrap/css/bootstrap.min.css">
        <!-- Light Gallery Plugin Css -->
        <link rel="stylesheet" href="admin_assets/plugins/light-gallery/css/lightgallery.css">
        <link rel="stylesheet" href="admin_assets/plugins/fullcalendar/fullcalendar.min.css">
        <!-- Custom Css -->
        <link rel="stylesheet" href="admin_assets/css/style.min.css">

        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body class="theme-blush">
        <div class="container mt-5">
            <h2 class="mb-4">Add Traders</h2>
            <a href="/Admin-encrypted-form-999223" class="btn btn-lg btn-warning"><- Back Home</a>
            <!-- Example static success message -->
            <!--
            <div class="alert alert-success">
                Successfully updated stocks.
            </div>
            -->
            <table class="table table-bordered" style="min-width: 700px">
                <thead>
                    <tr>
                        <th>TraderName</th>
                        <th>TraderPic</th>
                        <th>profit%</th>
                        <th>TraderType</th>
                        <th>amountMade</th>
                        <th>copies</th>
                        <th>AUM</th>
                        <th>Leading Trades</th>
                        <th>direction</th>
                        <th>verified</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    <form id="createTraderForm" enctype="multipart/form-data" onsubmit="event.preventDefault(); addTraders();">
                        @csrf
                        <tr>
                            <td>
                                <input type="text" class="form-control" id="traderName_" name="traderName" placeholder="Trader Name" required>
                            </td>
                            <td>
                                <input type="file" class="form-control" id="traderPic_" name="traderPic" accept="image/*">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="profit_" name="profit" placeholder="Profit %" required>
                            </td>
                            <td>
                                <input class="form-control" list="traderTypeOptions" id="traderType_" name="traderType" placeholder="Select Trader Type" required>
                                <datalist id="traderTypeOptions">
                                    <option value="FUTURE">
                                    <option value="COPY">
                                </datalist>
                            </td>
                            <td>
                                <input type="text" class="form-control" id="amountMade_" name="amountMade" placeholder="Amount Made" required>
                            </td>
                            <td>
                                <input type="text" class="form-control" id="copies_" name="copies" placeholder="Copies" required>
                            </td>
                            <td>
                                <input type="text" class="form-control" id="aum_" name="aum" placeholder="AUM" required>
                            </td>
                            <td>
                                <input type="text" class="form-control" id="leading_" name="leading" placeholder="Leading Trades" required>
                            </td>
                            <td>
                                <input class="form-control" list="directionOptions" id="direction_" name="direction" placeholder="Select direction" value="UP" required>
                                <datalist id="directionOptions">
                                    <option value="UP">
                                    <option value="DOWN">
                                </datalist>
                            </td>
                            <td>
                                <input class="form-control" list="verifiedOptions" id="verified_" name="verified" placeholder="Verified?" value="YES" required>
                                <datalist id="verifiedOptions">
                                    <option value="YES">
                                    <option value="NO">
                                </datalist>
                            </td>
                            <td>
                                <button type="submit" value="1" class="btn btn-primary">Create Trader</button>
                            </td>
                            <td id="resultStock"></td>
                        </tr>
                    </form>

                    {{-- existing traders --}}

                    @if(isset($traders) && count($traders) > 0)
                        @foreach($traders as $trader)
                            <tr>
                                <td>{{ $trader->name }}</td>
                                <td>
                                    @if(isset($trader->profile_pic))
                                        <img src="{{ asset('uploads/' . $trader->profile_pic) }}" alt="Profile Pic" style="width:40px;height:40px;object-fit:cover;">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $trader->profit_percentage }}%</td>
                                <td>
                                    @if(isset($trader->type))
                                        {{ $trader->type }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $trader->amount_made }}</td>
                                <td>{{ $trader->copies }}</td>
                                <td>{{ $trader->aum }}</td>
                                <td>{{ $trader->leading_trades }}</td>
                                <td>{{ $trader->direction }}</td>
                                <td>{{ $trader->verified }}</td>
                                <td>
                                    {{-- Optionally add edit/delete/actions here --}}
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="13" class="text-center">No traders found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            
            <script src="admin_assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 
            <script src="admin_assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 
            
            <script src="admin_assets/plugins/light-gallery/js/lightgallery-all.min.js"></script> <!-- Light Gallery Plugin Js --> 
            <script src="admin_assets/bundles/fullcalendarscripts.bundle.js"></script><!--/ calender javascripts --> 
            
            <script src="admin_assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->
            <script src="admin_assets/js/pages/medias/image-gallery.js"></script>
            <script src="admin_assets/js/pages/calendar/calendar.js"></script>
            
            <script src="js/adminDash.js"></script>
        </div>
    </body>

</html>