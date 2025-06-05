<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(InitialInvestmentDataSeeder::class);
        // Jika Anda punya AdminUserSeeder, panggil juga:
        // $this->call(AdminUserSeeder::class);
    }
}