<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample data for customers
        $customers = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'phone' => '1234567890',
                'status' => 'active',
                'user_id' => 1, // Ensure this matches the foreign key in customer_addresses
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'phone' => '0987654321',
                'status' => 'active',
                'user_id' => 2,
            ],
        ];

        // Insert data into the customers table
        DB::table('customers')->insert($customers);
    }
}
