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
//        $cash_plus = DB::table('all_transactions')
//            ->where('account_id', 1)->where('type_transaction_id', 1)
//            ->where('cancelled', 0)->sum('summ');
//        $cash_minus = DB::table('all_transactions')
//            ->where('account_id', 1)->where('type_transaction_id', 2)
//            ->where('cancelled', 0)->sum('summ');
//        $card_plus = DB::table('all_transactions')
//            ->where('account_id', 2)->where('type_transaction_id', 1)
//            ->where('cancelled', 0)->sum('summ');
//        $card_minus = DB::table('all_transactions')
//            ->where('account_id', 2)->where('type_transaction_id', 2)
//            ->where('cancelled', 0)->sum('summ');
//        $cash_perekaz = DB::table('all_transactions')
//            ->where('categorie_id', 4)->sum('summ');
//        $card_perekaz = DB::table('all_transactions')
//            ->where('categorie_id', 7)->sum('summ');
//
//        $cash_full = $cash_plus - $cash_minus - $card_perekaz;
//        $card_full = $card_plus - $card_minus - $cash_perekaz;
//
//        DB::table('accounts')
//            ->where('id', 1)->update(['balance' => $cash_full]);
//        DB::table('accounts')
//            ->where('id', 2)->update(['balance' => $card_full]);


        $acc = Accounts::all();
        $alltrans = AllTransactions::with('account' , 'categorie' , 'typetransaction')->orderBy('id' , 'desc')->get();

//        dd($alltrans->toArray());

        return view('cassa')->with([
            'acc' => $acc,
            'alltrans' => $alltrans,
        ]);

        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $acc = Accounts::all();
        $tra = TypeTransactions::all();
        $cat = Categories::all();

        return view('transactions')->with([
            'acc' => $acc,
            'tra' => $tra,
            'cat' => $cat,
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

        $alltr = new AllTransactions();
        $alltr->categorie_id         = $validated['categorie_id'];
        $alltr->type_transaction_id  = $validated['type_transaction_id'];
        $alltr->account_id           = $validated['account_id'];
        $alltr->summ                 = $validated['summ'];
        $result = $alltr->save();

        $acc = Accounts::where('id',$validated['account_id'])->first();
        $cc = Categories::where('id',$validated['categorie_id'])->first();
        $tt = TypeTransactions::where('id',$validated['type_transaction_id'])->first();


        if ($tt->name_tra === 'Поповнення') {
            $acc->balance = $acc->balance + $validated['summ'];
        }
        if ($tt->name_tra === 'Витрати') {
            $acc->balance = $acc->balance - $validated['summ'];
        }
        if ($cc->name_cat === 'Зняття коштів з безготівкового рахунку') {
            $cash_perekaz = Accounts::where('id', 2)->first();
            $cash_perekaz->balance = $cash_perekaz->balance - $validated['summ'];
            $cash_perekaz->save();
        }
        if ($cc->name_cat === 'Поповнення рахунку з готівкового') {
            $card_perekaz = Accounts::where('id', 1)->first();
            $card_perekaz->balance = $card_perekaz->balance - $validated['summ'];
            $card_perekaz->save();
        }
        $resultAcc = $acc->save();



        if($result && $resultAcc) {
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
//        dd($cancelled->toArray());

        $cancel_tr = new AllTransactions();
        $cancel_tr->categorie_id         = $cancelled->categorie_id;
        $cancel_tr->type_transaction_id  = $cancelled->type_transaction_id;
        $cancel_tr->account_id           = $cancelled->account_id;
        $cancel_tr->summ                 = $cancelled->summ;
        $cancel_tr->cancelled            = $new_cancelled;
        $cancel_tr->cancelled_id         = $id;
        $result = $cancel_tr->save();

        $acc = Accounts::where('id',$cancelled->account_id)->first();
        $cc = Categories::where('id',$cancelled->categorie_id)->first();
        $tt = TypeTransactions::where('id',$cancelled->type_transaction_id)->first();

        if ($tt->name_tra === 'Поповнення') {
            $acc->balance = $acc->balance - $cancelled->summ;
        }
        if ($tt->name_tra === 'Витрати') {
            $acc->balance = $acc->balance + $cancelled->summ;
        }
        if ($cc->name_cat === 'Зняття коштів з безготівкового рахунку') {
            $cash_perekaz = Accounts::where('id', 2)->first();
            $cash_perekaz->balance = $cash_perekaz->balance + $cancelled->summ;
            $cash_perekaz->save();
        }
        if ($cc->name_cat === 'Поповнення рахунку з готівкового') {
            $card_perekaz = Accounts::where('id', 1)->first();
            $card_perekaz->balance = $card_perekaz->balance + $cancelled->summ;
            $card_perekaz->save();
        }
        $acc->save();

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
