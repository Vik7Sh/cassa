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
            'name_category' => 'Готівковий продаж без чеку',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '1',
            'account_id' => '1',
            'name_category' => 'Продаж з відправленням товару',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '1',
            'account_id' => '1',
            'name_category' => 'Продаж онлайн',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '1',
            'account_id' => '1',
            'name_category' => 'Зняття коштів з безготівкового рахунку',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '1',
            'account_id' => '2',
            'name_category' => 'Продаж по еквайрингу',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '1',
            'account_id' => '2',
            'name_category' => 'Інші поповнення безготівкового рахунку',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '1',
            'account_id' => '2',
            'name_category' => 'Поповнення рахунку з готівкового',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '2',
            'account_id' => '1',
            'name_category' => 'Повернення товару',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '2',
            'account_id' => '1',
            'name_category' => 'Закупка нового товару',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '2',
            'account_id' => '1',
            'name_category' => 'Інші витрати',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '2',
            'account_id' => '2',
            'name_category' => 'Послуги банку',
        ]);
        DB::table('categories')->insert([
            'type_transaction_id' => '2',
            'account_id' => '2',
            'name_category' => 'Інші витрати',
        ]);

        //
    }
}
