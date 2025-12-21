<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use App\Models\Trade;
    use App\Models\Trader;
    use App\Models\User;

    class AdminController extends Controller{

        // function to display all users
        public function displayUsers()
        {
            // Retrieve all users from the database, order by id DESC
            $users = User::orderBy('id', 'DESC')->get();

            // Get all traders
            // $traders = Trader::orderBy('id', 'DESC')->get();

            // For each user, get their trades from the Trade model
            $userTrades = [];
            foreach ($users as $user) {
                // Assuming Trade model has a 'user_id' foreign key
                $userTrades[$user->id] = Trade::where('users_id', $user->id)->get();
            }

            return view('adminDashboard.index', [
                'users' => $users,
                'userTrades' => $userTrades
            ]);
        }




        public function createTraders(Request $request){
            // Validate incoming request
            $validated = $request->validate([
                'traderName'    => 'required|string|max:255',
                'profit'        => 'required|string',
                'amountMade'    => 'required|string',
                'copies'        => 'required|string',
                'aum'           => 'required|string',
                'leading'       => 'required|string',
                'direction'     => 'required|string|max:255',
                'verified'      => 'required|string|max:255',
                'traderPic'     => 'nullable|file|image|max:2048',
            ]);

            // Handle file upload if exists and rename it, save to public/uploads and get new filename
            $picFileName = null;
            if ($request->hasFile('traderPic')) {
                $file = $request->file('traderPic');
                // Generate a unique filename with time and random string plus extension
                $picFileName = 'trader_' .uniqid() . '.' . $file->getClientOriginalExtension();
                // Save to public/uploads directory
                $file->move(public_path('uploads'), $picFileName);
            }

            // Create trader record (assuming App\Models\Trader exists and matches columns)
            $trader = new Trader();
            $trader->name                   = $validated['traderName'];
            $trader->profit_percentage      = $validated['profit'];
            $trader->amount_made            = $validated['amountMade'];
            $trader->copies                 = $validated['copies'];
            $trader->aum                    = $validated['aum'];
            $trader->leading_trades         = $validated['leading'];
            $trader->direction              = $validated['direction'];
            $trader->verified               = $validated['verified'];
            if ($picFileName !== null) {
                $trader->profile_pic = $picFileName;
            }

            $trader->save();

            // Return success response for AJAX
            return response()->json([
                'success' => true,
                'message' => 'Trader created successfully!',
                'trader_id' => $trader->id
            ]);
        }






        // function to display all the current traders..

        public function showAllTraders(){

            // Fetch all traders from the Trader model, latest first
            $traders = Trader::orderBy('id', 'desc')->get();

            // Pass the traders to the adminDashboard.createTraders view
            return view('adminDashboard.createTraders', ['traders' => $traders]);
        }


        // function to approve investment
        public function approveInvestment(Request $request)
        {
            $userId = $request->input('user_id');

            // Find the user by id
            $user = User::find($userId);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                ]);
            }

            // Update user's status to APPROVED
            $user->status = 'APPROVED';
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'User status updated to APPROVED.',
            ]);
        }



    // Function to change PnL (Profit and Loss) of a trader
    public function changePnl(Request $request)
    {
        $traderId = $request->input('trader_id');
        $pnl = $request->input('pnl');

        $trader = Trader::find($traderId);

        if (!$trader) {
            return response()->json([
                'success' => false,
                'message' => 'Trader not found.',
            ]);
        }

        $trader->profit = $pnl;
        $trader->save();

        return response()->json([
            'success' => true,
            'message' => 'Trader profit updated successfully.'
        ]);
    }

    // Function to change total assets of a trader
    public function changeTotalAssets(Request $request)
    {
        $traderId = $request->input('trader_id');
        $aum = $request->input('aum');

        $trader = Trader::find($traderId);

        if (!$trader) {
            return response()->json([
                'success' => false,
                'message' => 'Trader not found.',
            ]);
        }

        $trader->aum = $aum;
        $trader->save();

        return response()->json([
            'success' => true,
            'message' => 'Trader assets updated successfully.'
        ]);
    }

    // Function to suspend a user by id
    public function suspendUser(Request $request)
    {
        $userId = $request->input('user_id');

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ]);
        }

        $user->status = 'SUSPENDED';
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User has been suspended successfully.'
        ]);
    }


    }
