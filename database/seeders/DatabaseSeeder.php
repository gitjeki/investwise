<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(InitialInvestmentDataSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(AdminUserSeeder::class);
    }
}