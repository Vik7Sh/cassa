<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    public function account(){
        return $this->belongsTo(Accounts::class);
    }
    public function alltransaction(){
        return $this->hasMany(AllTransactions::class);
    }
    public function typetransaction(){
        return $this->belongsTo(TypeTransactions::class);
    }
    //
}
