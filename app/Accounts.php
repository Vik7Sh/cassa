<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    public function alltransaction(){
        return $this->hasMany(AllTransactions::class);
    }
    public function categorie(){
        return $this->hasMany(Categories::class);
    }
    //
}
