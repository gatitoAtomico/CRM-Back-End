<?php

namespace App\Http\Controllers;

use App\Transactions;
use Illuminate\Http\Request;


class TransactionsController extends Controller
{

    public function get(Request $request)
    {
        $transactions = Transactions::where('user_id',$request->user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return response()->json([
            'transactions' => $transactions,
            'user' => $request->user()
        ], 200);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'amount'=>
                "required|numeric|between:1,5000"
        ]);

        $inputs = ['user_id' =>  $request->user()->id,'amount' => $request->amount];
        Transactions::create($inputs);

        $transactions = Transactions::where('user_id',$request->user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return response()->json([
            'transactions' => $transactions,
            'message' => "The transaction with amount ". $request->amount. " was successful"
        ], 200);


    }
}
