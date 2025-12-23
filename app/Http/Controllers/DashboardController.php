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
                
                return redirect()->back()->with('success', 'Deposit Processing, contact admin for approval.');
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

                return redirect()->back()->with('success', 'Withdrawal request submitted. Awaiting admin approval.');
            } catch (\Exception $e) {
                error_log($e->getMessage());
                return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
            }
        }


       



        // function to display traders that the admin created
        public function showFuturesTraders(){
            
            // Get all traders from the database
            $traders = Trader::all();

            // Send the traders data back to the 'futures' blade view
            return view('future', ['traders' => $traders]);
        }



        public function futureDetails(Request $request){


            // Get the trader ID from the URL (?id=...)
            $id = $request->query('id');

            // Retrieve the trader with all relevant information
            $trader = Trader::find($id);

            // Optionally, handle trader not found
            if (!$trader) {
                return redirect()->route('futures')->with('error', 'Trader not found.');
            }

            // Return the 'future-details' view with trader details
            return view('futureDetails', ['trader' => $trader]);
        }



        // function to enable users copy trades
        public function copyTrades(Request $request){
            try {
                
                error_log("came----------------------");
    
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


    }
