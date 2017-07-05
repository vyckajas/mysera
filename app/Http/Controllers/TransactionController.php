<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        /*
         * Checking that was the operation
         *
         * Operation -> Cash In
         */
        if (request('operation') === 'cash_in'){

            // Getting money & adding taxes
            $income = request('amount');
            $tax = $income * 0.003;
            if ($tax > 5){
                $tax = 5;
            }
            $amount = $income - $tax;

            // Creating transaction
            Transaction::create([
                'amount' => $amount,
                'currency' => request('currency'),
                'user_id' => Auth()->user()->id,
                'operation' => request('operation'),
                'tax' => $tax,
            ]);

            // Checking the currency & converting to EUR
            $currency = request('currency');
            if ($currency === 'JPY'){
                $amount = $amount / 129.53;
            } elseif ($currency === 'USD'){
                $amount = $amount / 1.1497;
            }

            // Add money to your current account
            $balance = Auth()->user()->amount;
            $totalAmount = $balance + $amount;

            // Updating user account in DB
            $id = Auth()->user()->id;
            $user = User::find($id);
            $user->amount = $totalAmount;
            $user->save();

        } else {
            /*
             * Operation -> Cash Out
             */

            // Amount of money willing to take
            $cashout = request('amount');

            // Adding taxes
            $tax = $cashout * 0.03;
            if ($tax < 0.5){
                $tax = 0.5;
            }
            $amount = $cashout + $tax;

            // Creating transaction
            Transaction::create([
                'amount' => $cashout,
                'currency' => request('currency'),
                'user_id' => Auth()->user()->id,
                'operation' => request('operation'),
                'tax' => $tax,
            ]);

            // Checking the currency & converting to EUR
            $currency = request('currency');
            if ($currency === 'JPY'){
                $amount = $amount / 129.53;
            } elseif ($currency === 'USD'){
                $amount = $amount / 1.1497;
            }

            // Subtract money from your current account
            $balance = Auth()->user()->amount;
            $totalAmount = $balance - $amount;

            // Updating user account in DB
            $id = Auth()->user()->id;
            $user = User::find($id);
            $user->amount = $totalAmount;
            $user->save();
        }

        // Redirecting to Home page
        return redirect('/home');
    }
}