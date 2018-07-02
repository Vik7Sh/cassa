<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    public function allTransaction(){
        return $this->hasMany(AllTransactions::class);
    }
    public function category(){
        return $this->hasMany(Categories::class);
    }
    //
}
