<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AllTransactions extends Model
{
    public function account(){
        return $this->belongsTo(Accounts::class);
    }
    public function categorie(){
        return $this->belongsTo(Categories::class);
    }
    public function typetransaction(){
        return $this->belongsTo(TypeTransactions::class, 'type_transaction_id', 'id');
    }
    //
}
