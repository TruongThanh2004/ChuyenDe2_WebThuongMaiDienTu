<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_items')->insert([
            [
                'order_items_id' =>'1',
                'order_id' =>'1',
                'product_id'=> '2',
                'quantity' => 1099.99,
            ],[
                
            ],[
                'order_items_id' =>'2',
                'order_id' =>'1',
                'product_id'=> '3',
                'quantity' => 749.99,
            ]
        ]);
    }
}
