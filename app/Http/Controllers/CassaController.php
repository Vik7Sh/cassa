<?php

namespace App\Http\Controllers;

use App\Accounts;
use App\AllTransactions;
use App\Categories;
use App\Http\Requests\TransactionPostRequest;
use App\TypeTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CassaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $accounts = Accounts::all();
        $allTransactions = AllTransactions::with('account' , 'category' , 'typeTransaction')->orderBy('id' , 'desc')->get();

        return view('cassa')->with([
            'accounts' => $accounts,
            'allTransactions' => $allTransactions,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Accounts::all();
        $transactions = TypeTransactions::all();
        $categories = Categories::all();

        return view('transactions')->with([
            'accounts' => $accounts,
            'transactions' => $transactions,
            'categories' => $categories,
        ]);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionPostRequest $request)
    {

        if (isset($request->validator) && $request->validator->fails()) {
            return redirect()->back()->withError('Перевірте введені дані!')->withInput();
        }

        $validated = $request->validated();

        $allTransactions = new AllTransactions();
        $allTransactions->category_id         = $validated['category_id'];
        $allTransactions->type_transaction_id  = $validated['type_transaction_id'];
        $allTransactions->account_id           = $validated['account_id'];
        $allTransactions->summ                 = $validated['summ'];
        $result = $allTransactions->save();

        $accounts = Accounts::where('id',$validated['account_id'])->first();
        $categories = Categories::where('id',$validated['category_id'])->first();
        $typeTransactions = TypeTransactions::where('id',$validated['type_transaction_id'])->first();

        if ($typeTransactions->id === 1) {
            $accounts->balance = $accounts->balance + $validated['summ'];
        }
        if ($typeTransactions->id === 2) {
            $accounts->balance = $accounts->balance - $validated['summ'];
        }
        if ($categories->id === 4) {
            $cash_perekaz = Accounts::where('id', 2)->first();
            $cash_perekaz->balance = $cash_perekaz->balance - $validated['summ'];
            $cash_perekaz->save();
        }
        if ($categories->id === 7) {
            $card_perekaz = Accounts::where('id', 1)->first();
            $card_perekaz->balance = $card_perekaz->balance - $validated['summ'];
            $card_perekaz->save();
        }
        $resultAccount = $accounts->save();



        if($result && $resultAccount) {
            return redirect('/');
        } else {
            return redirect()->back()->withError('Неможу зберегти дані')->withInput();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $new_cancelled = '2';
        $cancelled = AllTransactions::where('id', $id)->first();
        AllTransactions::where('id', $id)->update(['cancelled' => 1]);

        $cancelTransaction = new AllTransactions();
        $cancelTransaction->category_id         = $cancelled->category_id;
        $cancelTransaction->type_transaction_id  = $cancelled->type_transaction_id;
        $cancelTransaction->account_id           = $cancelled->account_id;
        $cancelTransaction->summ                 = $cancelled->summ;
        $cancelTransaction->cancelled            = $new_cancelled;
        $cancelTransaction->cancelled_id         = $id;
        $result = $cancelTransaction->save();

        $accounts = Accounts::where('id',$cancelled->account_id)->first();
        $categories = Categories::where('id',$cancelled->category_id)->first();
        $typeTransactions = TypeTransactions::where('id',$cancelled->type_transaction_id)->first();

        if ($typeTransactions->id === 1) {
            $accounts->balance = $accounts->balance - $cancelled->summ;
        }
        if ($typeTransactions->id === 2) {
            $accounts->balance = $accounts->balance + $cancelled->summ;
        }
        if ($categories->id === 4) {
            $cash_perekaz = Accounts::where('id', 2)->first();
            $cash_perekaz->balance = $cash_perekaz->balance + $cancelled->summ;
            $cash_perekaz->save();
        }
        if ($categories->id === 7) {
            $card_perekaz = Accounts::where('id', 1)->first();
            $card_perekaz->balance = $card_perekaz->balance + $cancelled->summ;
            $card_perekaz->save();
        }
        $accounts->save();

        if($result) {
            return redirect('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
