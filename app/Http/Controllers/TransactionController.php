<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {

        $income = request('amount');

        $tax = $income * 0.0003;
        if ($tax > 5){
            $tax = 5;
        }

        $amount = $income - $tax;

        Transaction::create([
            'amount' => $amount,
            'currency' => request('currency'),
            'user_id' => Auth()->user()->id,
        ]);

        return redirect('/home');
    }
}
