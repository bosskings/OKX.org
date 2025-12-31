<?php

    namespace App\Http\Controllers;

    use App\Models\Transaction;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\Controller;
    use App\Models\Following;
    use App\Models\Trade;
    use App\Models\Trader;

    class DashboardController extends Controller{


        // function to display transaction history
        public function showDashboard()
        {
            try {
                // Fetch all transactions for the authenticated user
                $user = Auth::user();

                // You can change the logic here if you want all users' transactions for admin
                $transactions = Transaction::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

                // If there are no transactions, set a message
                if ($transactions->isEmpty()) {
                    return view('dashboard', [
                        'user' => $user,
                        'transactions' => $transactions,
                        'no_transactions_message' => 'No transactions have occurred yet.',
                    ]);
                }

                // error_log($transactions);
                return view('dashboard', [
                    'user' => $user,
                    'transactions' => $transactions,
                ]);
            } catch (\Exception $e) {
                error_log($e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while fetching transactions: ' . $e->getMessage());
            }
        }




        // function to aid users deposit

        public function deposit(Request $request){

            
            $user = User::find(Auth::id());

            try {
                // Validate input
                $request->validate([
                    'amount' => 'required|numeric|min:0.01',
                    'method' => 'required|string|max:255',
                ]);

                $amount = $request->input('amount');
                $transfer_method = $request->input('method');

                // Save transaction record
                Transaction::create([
                    'user_id' => $user->id,
                    'transaction_type' => 'DEPOSIT',
                    'amount' => $amount,
                    'status' => 'PENDING',
                    'method' => $transfer_method
                ]);
                
                return redirect()->back()->with('success', 'Deposit Processing.');
            } catch (\Exception $e) {
                error_log($e->getMessage());
                return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());

            }
        }




        public function withdrawRequest(Request $request)
        {
            try {
                // Get the current authenticated user
                $user = User::find(Auth::id());

                // Validate the incoming data
                $request->validate([
                    'amount' => 'required|numeric|',
                    'address' => 'required|string|',
                    'method' => 'required|string|',

                ]);

                $amount = $request->input('amount');
                $method = $request->input('method'); // e.g., crypto, bank, paypal
                $address = $request->input('address');

                // Save the withdraw request in the transactions table
                $transaction = new Transaction();
                $transaction->user_id = $user->id;
                $transaction->transaction_type = 'WITHDRAW';
                $transaction->amount = $amount;
                $transaction->method = $method;
                $transaction->address = $address;
                $transaction->status = 'PENDING';
                $transaction->save();

                return redirect()->back()->with('success', 'Withdrawal request Processing.');
            } catch (\Exception $e) {
                error_log($e->getMessage());
                return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
            }
        }


        // function to display future traders that the admin created
        public function showFuturesTraders(){
            // Only get traders with type 'FUTURE'
            $traders = Trader::where('type', 'FUTURE')->get();

            // Send the traders data back to the 'futures' blade view
            return view('future', ['traders' => $traders]);
        }



        public function futureDetails(Request $request){
            // Get the trader ID from the URL (?id=...)
            $id = $request->query('id');

            // Retrieve the current FUTURE trader by id
            $currentTrader = Trader::where('id', $id)
                                   ->where('type', 'FUTURE')
                                   ->first();

            // Optionally, handle trader not found
            if (!$currentTrader) {
                return redirect()->route('futures')->with('error', 'Trader not found.');
            }

            // Retrieve all FUTURE traders (excluding or including the current as needed)
            $allFutureTraders = Trader::where('type', 'FUTURE')->get();

            // Return the 'futureDetails' view with current trader and all future traders
            return view('futureDetails', [
                'currentTrader' => $currentTrader,
                'allFutureTraders' => $allFutureTraders
            ]);
        }


        // function to display spot traders that the admin created
        public function showSpotTraders(){
            // Only get traders with type 'FUTURE'
            $traders = Trader::where('type', 'SPOT')->get();

            // Send the traders data back to the 'futures' blade view
            return view('spot', ['traders' => $traders]);
        }


        public function spotDetails(Request $request){
            // Get the trader ID from the URL (?id=...)
            $id = $request->query('id');

            // Retrieve the current SPOT trader by id
            $currentTrader = Trader::where('id', $id)
                                   ->where('type', 'SPOT')
                                   ->first();

            // Optionally, handle trader not found
            if (!$currentTrader) {
                return redirect()->route('spot')->with('error', 'Trader not found.');
            }

            // Retrieve all SPOT traders (excluding or including the current as needed)
            $allSpotTraders = Trader::where('type', 'SPOT')->get();

            // Return the 'spotDetails' view with current trader and all spot traders
            return view('spotDetails', [
                'currentTrader' => $currentTrader,
                'allSpotTraders' => $allSpotTraders
            ]);
        }



        // function to enable users copy trades
        public function copyTrades(Request $request){
            try {
                
                // Validate input
                $request->validate([
                    'amount' => 'required|string',
                    'trader' => 'required|string',
                ]);
                
                $user_id = Auth::id();
                $amount = $request->input('amount');
                $trader_id = $request->input('trader');

                // Save the copy trade to trades table
                $trade = new Trade();
                $trade->users_id = $user_id;
                $trade->amount = $amount;
                $trade->type = 'future';
                $trade->trader = $trader_id;
                $trade->save();


                // also save to transaction table
                $transaction = new Transaction();
                $transaction->user_id = $user_id;
                $transaction->transaction_type = 'COPY TRADE';
                $transaction->amount = $amount;
                $transaction->status = 'SUCCESS';
                $transaction->method = 'crypto';
                $transaction->save();

                $following = new Following();
                $following->traders_id = $trader_id;
                $following->user_id = $user_id;
                $following->save();

                // Fetch the authenticated user
                $user = User::find(Auth::id());

                // Subtract the amount from user's balance and update
                if ($user && isset($user->available_balance)) {
                    $user->available_balance -= $amount;
                    $user->save();
                }


                return redirect()->back()->with('success', 'Trade copied successfully.');
            } catch (\Exception $e) {
                error_log($e->getMessage());
                return redirect()->back()->withInput()->with('error', 'An error occurred while copying trade: ' . $e->getMessage());
            }

        }


        // function to upload verification document for approval
        public function verifyIdentity(Request $request)
        {
            try {
                $user = User::find(Auth::id());

                $request->validate([
                    'document_type' => 'required|string|max:255',
                    'document_front' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
                    'document_back' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
                ]);

                // Handle file uploads
                $frontPath = null;
                $backPath = null;

                // Only allow picture file types: jpg, jpeg, png
                $allowedExtensions = ['jpg', 'jpeg', 'png'];

                if ($request->hasFile('document_front')) {
                    $frontFile = $request->file('document_front');
                    $frontExt = strtolower($frontFile->getClientOriginalExtension());
                    if (!in_array($frontExt, $allowedExtensions)) {
                        return redirect()->back()->withInput()->with('error', 'Only image files (JPG, JPEG, PNG) are allowed for the front document.');
                    }
                    $frontFileName = 'front_' . uniqid() . '.' . $frontExt;
                    $frontFile->move(public_path('uploads'), $frontFileName);
                    $frontPath = 'uploads/' . $frontFileName;
                }

                if ($request->hasFile('document_back')) {
                    $backFile = $request->file('document_back');
                    $backExt = strtolower($backFile->getClientOriginalExtension());
                    if (!in_array($backExt, $allowedExtensions)) {
                        return redirect()->back()->withInput()->with('error', 'Only image files (JPG, JPEG, PNG) are allowed for the back document.');
                    }
                    $backFileName = 'back_' . uniqid() . '.' . $backExt;
                    $backFile->move(public_path('uploads'), $backFileName);
                    $backPath = 'uploads/' . $backFileName;
                }

                // Update user model
                $user->verification_type = $request->input('document_type');
                $user->pic_front = $frontPath;
                $user->pic_back = $backPath;
                $user->status = 'PENDING'; // Set to pending for admin review
                $user->save();

                return redirect()->back()->with('success', 'Submitted successfully. Please wait for approval.');
            } catch (\Exception $e) {
                error_log($e->getMessage());
                return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
            }
        }





        // // function to display traders on spot
        // public function showFutureDetailsTraders()
        // {
        //     try {
        //         // Assuming you have a Trader model with a 'type' attribute (spot/future)
        //         $spotTraders = Trader::where('type', 'SPOT')->get();

        //         return view('futureDetails', ['traders' => $spotTraders]);
        //     } catch (\Exception $e) {
        //         error_log($e->getMessage());
        //         return redirect()->back()->with('error', 'Failed to fetch spot traders.');
        //     }
        // }

        // // function to display traders on spot
        // public function showSpotDetailsTraders()
        // {
        //     try {
        //         // Assuming you have a Trader model with a 'type' attribute (spot/future)
        //         $spotTraders = Trader::where('type', 'SPOT')->get();

        //         return view('spotDetails', ['traders' => $spotTraders]);
        //     } catch (\Exception $e) {
        //         error_log($e->getMessage());
        //         return redirect()->back()->with('error', 'Failed to fetch spot traders.');
        //     }
        // }




    }
