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
    <div class="container mt-5">
        <h2 class="mb-4">Change Stocks</h2>
        <a href="/Admin-encrypted-formatted-8987823" class="btn btn-lg btn-warning"><- Back Home</a>
        <!-- Example static success message -->
        <!--
        <div class="alert alert-success">
            Successfully updated stocks.
        </div>
        -->
        <table class="table table-bordered" style="min-width: 700px">
            <thead>
                <tr>
                    <th>Stock Name</th>
                    <th>ID</th>
                    <th>Deposit</th>
                    <th>Daily Profit %</th>
                    <th>Total Profit</th>
                    <th>Duration</th>
                    <th>Action</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!-- Example static row 1 -->
                <tr>
                    <td>AAPL</td>
                    <td>1</td>
                    <td>
                        <input type="number" step="0.01" id="deposit1" value="1000.00" class="form-control" required>
                    </td>
                    <td>
                        <input type="text" step="0.01" id="daily1" value="1.5" class="form-control" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" id="total1" value="1050.00" class="form-control" required>
                    </td>
                    <td>
                        <input type="text" id="duration1" value="7 days" class="form-control" required>
                    </td>
                    <td>
                        <button type="submit" value="1" class="btn btn-primary" onclick="updateStockFigure(1)">Update</button>
                    </td>
                    <td id="resultStock1"></td>
                </tr>
                <!-- Example static row 2 -->
                <tr>
                    <td>GOOGL</td>
                    <td>2</td>
                    <td>
                        <input type="number" step="0.01" id="deposit2" value="500.00" class="form-control" required>
                    </td>
                    <td>
                        <input type="text" step="0.01" id="daily2" value="2.0" class="form-control" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" id="total2" value="540.00" class="form-control" required>
                    </td>
                    <td>
                        <input type="text" id="duration2" value="5 days" class="form-control" required>
                    </td>
                    <td>
                        <button type="submit" value="2" class="btn btn-primary" onclick="updateStockFigure(2)">Update</button>
                    </td>
                    <td id="resultStock2"></td>
                </tr>
                <!-- Example static row 3 -->
                <tr>
                    <td>TSLA</td>
                    <td>3</td>
                    <td>
                        <input type="number" step="0.01" id="deposit3" value="2500.00" class="form-control" required>
                    </td>
                    <td>
                        <input type="text" step="0.01" id="daily3" value="1.2" class="form-control" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" id="total3" value="2600.00" class="form-control" required>
                    </td>
                    <td>
                        <input type="text" id="duration3" value="10 days" class="form-control" required>
                    </td>
                    <td>
                        <button type="submit" value="3" class="btn btn-primary" onclick="updateStockFigure(3)">Update</button>
                    </td>
                    <td id="resultStock3"></td>
                </tr>
                <!-- More static rows can be added as needed -->
            </tbody>
        </table>
        
        <script src="./admin_assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 
        <script src="./admin_assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 
        
        <script src="./admin_assets/plugins/light-gallery/js/lightgallery-all.min.js"></script> <!-- Light Gallery Plugin Js --> 
        <script src="./admin_assets/bundles/fullcalendarscripts.bundle.js"></script><!--/ calender javascripts --> 
        
        <script src="./admin_assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->
        <script src="./admin_assets/js/pages/medias/image-gallery.js"></script>
        <script src="./admin_assets/js/pages/calendar/calendar.js"></script>
        
        <script src="js/adminDash.js"></script>
    </div>
</body>
</html>