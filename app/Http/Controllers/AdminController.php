<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use App\Models\Trade;
    use App\Models\Trader;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Log as FacadesLog;

    class AdminController extends Controller{

        // function to display all users
        public function displayUsers()
        {
            try {
                // Retrieve all users from the database, order by id DESC
                $users = User::orderBy('id', 'DESC')->get();

                // Collect per-user data
                $userTrades = [];
                $userLatestPendingWithdraw = [];
                foreach ($users as $user) {
                    // Get trades for this user
                    $userTrades[$user->id] = Trade::where('users_id', $user->id)->get();

                    // Get only the latest PENDING WITHDRAW transaction for this user
                    $userLatestPendingWithdraw[$user->id] = Transaction::where('user_id', $user->id)
                        ->where('status', 'PENDING')
                        ->where('transaction_type', 'WITHDRAW')
                        ->orderBy('created_at', 'desc')
                        ->first();
                }

                // Get all PENDING DEPOSIT transactions
                $pendingDepositTransactions = Transaction::where('transaction_type', 'DEPOSIT')
                    ->where('status', 'PENDING')
                    ->get();


                return view('adminDashboard.index', [
                    'users' => $users,
                    'userTrades' => $userTrades,
                    'userLatestPendingWithdraw' => $userLatestPendingWithdraw,
                    'pendingDepositTransactions' => $pendingDepositTransactions,
                ]);
            } catch (\Exception $e) {
                // Optionally send the error to the log
                    FacadesLog::error('Admin displayUsers error: ' . $e->getMessage());
                return view('adminDashboard.index')->with(['error' => 'An unexpected error occurred.']);
            }
        }




        public function createTraders(Request $request){
            // Validate incoming request
            $validated = $request->validate([
                'traderName'    => 'required|string|max:255',
                'profit'        => 'required|string',
                'amountMade'    => 'required|string',
                'copies'        => 'required|string',
                'aum'           => 'required|string',
                'traderType'    => 'required|string',
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
            $trader->type                   = $validated['traderType'];
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
            $amount = $request->input('amount');
            $transactionId = $request->input('transaction_id');

            // Find the user by id
            $user = User::find($userId);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                ]);
            }

            // Find the transaction and update its status to SUCCESS
            $transaction = Transaction::find($transactionId);

            if (!$transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction not found.',
                ]);
            }

            $transaction->status = 'SUCCESS';
            $transaction->save();

            // Update user's available_balance and status
            // If user doesn't have available_balance column, fallback to balance
            if (isset($user->available_balance)) {
                $user->available_balance = ($user->available_balance ?? 0) + floatval($amount);
            } else {
                $user->balance = ($user->balance ?? 0) + floatval($amount);
            }
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Transaction approved, Balance increased.',
            ]);
        }


        public function changeBalance(Request $request)
        {
            $userId = $request->input('user_id');
            $amount = $request->input('amount');

            // Find the user by id
            $user = User::find($userId);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                ]);
            }

            // Update the available_balance (or fallback to balance if not present)
            if (isset($user->available_balance)) {
                $user->available_balance = floatval($amount);
            } else {
                $user->balance = floatval($amount);
            }
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'User balance updated successfully.'
            ]);
        }




        // Function to change PnL (Profit and Loss) of a trader
        public function changePnl(Request $request)
        {
            $traderId = $request->input('user_id');
            $amount = $request->input('amount');

            $user = User::find($traderId);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Trader not found.',
                ]);
            }

            $user->todays_pnl = $amount;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'User PNLprofit updated successfully.'
            ]);
        }




        // Function to change total assets of a trader
        public function changeTotalAssets(Request $request)
        {
            $userId = $request->input('user_id');
            $amount = $request->input('amount');

            $user = User::find($userId);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Trader not found.',
                ]);
            }

            $user->total_assets = $amount;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'user assets updated successfully.'
            ]);
        }



        // Function to suspend a user by id
        public function suspendUser(Request $request)
        {
            $userId = $request->input('user_id');
            $action = $request->input('data');

            $user = User::find($userId);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                ]);
            }

            $user->suspended = $action;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'User has been suspended successfully.'
            ]);
        }



        public function verifyUser(Request $request)
        {
            $userId = $request->input('user_id');
            $status = $request->input('data');

            $user = User::find($userId);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                ]);
            }

            $user->status = $status;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'User status updated successfully.'
            ]);
        }


        public function changePassword(Request $request)
        {
            $userId = $request->input('user_id');
            $newPassword = $request->input('password');

            $user = User::find($userId);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                ]);
            }

            // Encrypt the password as usual (using bcrypt)
            $user->password = bcrypt($newPassword);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully.'
            ]);
        }





        public function approveWithdrawal(Request $request)
        {
            // Validate incoming data
            try {
                $request->validate([
                    'user_id' => 'required|integer',
                    'status' => 'required|string',
                    'amount' => 'required|numeric',
                    'withdraw_id' => 'required|integer',
                ]);
            
                $userId = $request->input('user_id');
                $amount = floatval($request->input('amount'));
                $status = $request->input('status');
                $withdrawId = $request->input('withdraw_id');

                // Retrieve user
                $user = User::find($userId);

                // Find the withdrawal transaction by ID
                $transaction = Transaction::find($withdrawId);
              
                if (strtoupper($status) === 'DECLINED') {
                    $transaction->status = 'DECLINED';
                    $transaction->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'Withdrawal declined and status updated.',
                    ]);
                } elseif (strtoupper($status) === 'SUCCESS') {
                    // Check available_balance and subtract withdrawal amount
                    if (!isset($user->available_balance) || $user->available_balance < $amount) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Insufficient available balance.',
                        ]);
                    }
                    
                    // Update the original withdrawal request as SUCCESS
                    $transaction->status = 'SUCCESS';
                    $transaction->save();

                    // Subtract from user
                    $user->available_balance = $user->available_balance - $amount;
                    $user->save();


                    return response()->json([
                        'success' => true,
                        'message' => 'Withdrawal approved, balance updated, and transaction recorded.',
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid status.',
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage(),
                ]);
            }
        }


    }
