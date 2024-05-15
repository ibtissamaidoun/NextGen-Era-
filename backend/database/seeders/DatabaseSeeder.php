<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(AdministrateursTableSeeder::class);
        $this->call(AnimateursTableSeeder::class);
        $this->call(ParentmodelsTableSeeder::class);
        $this->call(PacksTableSeeder::class); 
        $this->call(HorairesTableSeeder::class);
        $this->call(EnfantsTableSeeder::class);
        $this->call(PaiementsTableSeeder::class);
        $this->call(ActivitesTableSeeder::class); 
        $this->call(OffresTableSeeder::class);
        $this->call(DemandesTableSeeder::class); 
        $this->call(DevisTableSeeder::class); 
        $this->call(FacturesTableSeeder::class);

        
    }
}
