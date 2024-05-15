<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nom' => 'hilaly',
            'prenom' => 'anas',
            'email' => 'admin@example.com',
            'telephone_portable' => '0601020304',
            'telephone_fixe' => '0501020304',
            'mot_de_passe' => '123',
            'role' => 'admin',
        ]);

        User::create([
            'nom' => 'sakhri',
            'prenom' => 'mohamed',
            'email' => 'parent@example.com',
            'telephone_portable' => '0601020306',
            'telephone_fixe' => '0501020303',
            'mot_de_passe' => '123',
            'role' => 'parent',
        ]);

        User::create([
            'nom' => 'naya',
            'prenom' => 'taha',
            'email' => 'animateur@example.com',
            'telephone_portable' => '0601020306',
            'telephone_fixe' => '0501020303',
            'mot_de_passe' => '123',
            'role' => 'animateur',
        ]);


        User::create([
            'nom' => 'tajidi',
            'prenom' => 'malika',
            'email' => 'parent1@example.com',
            'telephone_portable' => '0601020456',
            'telephone_fixe' => '0501020345',
            'mot_de_passe' => '123',
            'role' => 'parent',
        ]);

        User::create([
            'nom' => 'ouladmaalem',
            'prenom' => 'ayoub',
            'email' => 'animateur1@example.com',
            'telephone_portable' => '0601020306',
            'telephone_fixe' => '0501020303',
            'mot_de_passe' => '123',
            'role' => 'animateur',
        ]);

        User::create([
            'nom' => 'smihi',
            'prenom' => 'aroua',
            'email' => 'animateur2@example.com',
            'telephone_portable' => '0601020306',
            'telephone_fixe' => '0501020303',
            'mot_de_passe' => '123',
            'role' => 'animateur',
        ]);

        User::create([
            'nom' => 'tabla',
            'prenom' => 'amine',
            'email' => 'animateur3@example.com',
            'telephone_portable' => '0601020306',
            'telephone_fixe' => '0501020303',
            'mot_de_passe' => '123',
            'role' => 'animateur',
        ]);
        // Ajoutez d'autres utilisateurs selon vos besoins
    }
}
