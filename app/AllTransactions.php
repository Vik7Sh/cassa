<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AllTransactions extends Model
{
    public function account(){
        return $this->belongsTo(Accounts::class);
    }
    public function category(){
        return $this->belongsTo(Categories::class);
    }
    public function typeTransaction(){
        return $this->belongsTo(TypeTransactions::class, 'type_transaction_id', 'id');
    }
    //
}
