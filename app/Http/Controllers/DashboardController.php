<?php

    namespace App\Http\Controllers;

    use App\Models\Transaction;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\Controller;

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
                
                // Update user's available_balance
                $user->available_balance = ($user->available_balance ?? 0) + $amount;
                $user->save();

                // Save transaction record
                Transaction::create([
                    'user_id' => $user->id,
                    'transaction_type' => 'DEPOSIT',
                    'amount' => $amount,
                    'status' => 'SUCCESS',
                    'method' => $transfer_method
                ]);
                
                return redirect()->back()->with('success', 'Deposit successful.');
            } catch (\Exception $e) {
                error_log($e->getMessage());
                return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());

            }
        }


    }
