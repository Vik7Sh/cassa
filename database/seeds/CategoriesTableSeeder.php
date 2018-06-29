<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'type_transaction_id' => '1',
            'account_id' => '1',
            'name_cat' => 'Готівковий продаж без чеку',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '1',
            'account_id' => '1',
            'name_cat' => 'Продаж з відправленням товару',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '1',
            'account_id' => '1',
            'name_cat' => 'Продаж онлайн',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '1',
            'account_id' => '1',
            'name_cat' => 'Зняття коштів з безготівкового рахунку',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '1',
            'account_id' => '2',
            'name_cat' => 'Продаж по еквайрингу',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '1',
            'account_id' => '2',
            'name_cat' => 'Інші поповнення безготівкового рахунку',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '1',
            'account_id' => '2',
            'name_cat' => 'Поповнення рахунку з готівкового',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '2',
            'account_id' => '1',
            'name_cat' => 'Повернення товару',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '2',
            'account_id' => '1',
            'name_cat' => 'Закупка нового товару',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '2',
            'account_id' => '1',
            'name_cat' => 'Інші витрати',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '2',
            'account_id' => '2',
            'name_cat' => 'Послуги банку',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '2',
            'account_id' => '2',
            'name_cat' => 'Інші витрати',
        ]);

        //
    }
}
