<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        // $this->call(OperationsTableSeeder::class);
        $this->call(ConceptsTableSeeder::class);
        $this->call(ConceptsProviderSeeder::class);
        $this->call(AccountManagementBalanceSeeder::class);
        $this->call(AccountsUnicoSeeder::class);
        // $this->call(ExpenseServiceSeeder::class);
        // $this->call(ProvidersTableSeeder::class);
    }
}
