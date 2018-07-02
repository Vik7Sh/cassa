<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeTransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_transactions')->insert([
            'name_transaction' => 'Поповнення',
        ]);
        DB::table('type_transactions')->insert([
            'name_transaction' => 'Витрати',
        ]);
        //
    }
}
