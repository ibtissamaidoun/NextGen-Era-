<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Activite;

class ActivitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Activite::create([
            'titre' => 'Cours de programmation',
            'description' => 'Cours de programmation en PHP et Laravel',
            'objectifs' => 'Apprendre le développement web avec PHP et Laravel',
            'image_pub' => 'programming.jpg',
            'fiche_pdf' => 'programming_fiche.pdf',
            'lien_youtube' => 'https://www.youtube.com/watch?v=programmingvideo',
            'nbr_seances_semaine' => 2,
            'tarif' => 60.00,
            'effectif_min' => 5,
            'effectif_max' => 15,
            'effectif_actuel' => 0,
            'age_min' => 13,
            'age_max' => 17,
            'status' => 'inactive',
            'date_debut_etud' => '2024-06-01',
            'date_fin_etud' => '2024-08-31',
            'type_activite' => 'atelier',
            'domaine_activite' => 'Informatique',
            'administrateur_id' => 1,
        ]);

        Activite::create([
            'titre' => 'Formation en design graphique',
            'description' => 'Apprenez à créer des designs graphiques époustouflants',
            'objectifs' => 'Maîtriser les outils de conception graphique comme Adobe Photoshop et Illustrator',
            'image_pub' => 'design.jpg',
            'fiche_pdf' => 'design_fiche.pdf',
            'lien_youtube' => 'https://www.youtube.com/watch?v=designvideo',
            'nbr_seances_semaine' => 2,
            'tarif' => 80.00,
            'effectif_min' => 3,
            'effectif_max' => 10,
            'effectif_actuel' => 5,
            'age_min' => 10,
            'age_max' => 14,
            'status' => 'active',
            'date_debut_etud' => '2024-07-01',
            'date_fin_etud' => '2024-09-30',
            'type_activite' => 'atelier',
            'domaine_activite' => 'Créativité',
            'administrateur_id' => 1,
        ]);


        Activite::create([
            'titre' => 'Communication',
            'description' => 'Leçons de langues étrangères pour apprendre ou améliorer vos compétences linguistiques',
            'objectifs' => 'Maîtriser une nouvelle langue, pratiquer la conversation et élargir ses horizons culturels',
            'image_pub' => 'langues.jpg',
            'fiche_pdf' => 'langues_fiche.pdf',
            'lien_youtube' => 'https://www.youtube.com/watch?v=languesvideo',
            'nbr_seances_semaine' => 2,
            'tarif' => 50.00,
            'effectif_min' => 3,
            'effectif_max' => 10,
            'effectif_actuel' => 7,
            'age_min' => 4,
            'age_max' => 7,
            'status' => 'active',
            'date_debut_etud' => '2024-08-15',
            'date_fin_etud' => '2024-11-15',
            'type_activite' => 'atelier',
            'domaine_activite' => 'Formation',
            'administrateur_id' => 1,
        ]);

        Activite::create([
            'titre' => 'Introduction à l IA',
            'description' => 'Découvrez les principes fondamentaux de lintelligence artificielle et ses applications dans le monde réel.',
            'objectifs' => 'Comprendre les concepts de base de l IA, explorer les algorithmes d apprentissage machine et les réseaux neuronaux.',
            'image_pub' => 'ia.jpg',
            'fiche_pdf' => 'ia_fiche.pdf',
            'lien_youtube' => 'https://www.youtube.com/watch?v=IAvideo',
            'nbr_seances_semaine' => 1,
            'tarif' => 60.00,
            'effectif_min' => 5,
            'effectif_max' => 15,
            'effectif_actuel' => 0,
            'age_min' => 14,
            'age_max' => 17,
            'status' => 'inactive',
            'date_debut_etud' => '2024-08-01',
            'date_fin_etud' => '2024-11-01',
            'type_activite' => 'atlier',
            'domaine_activite' => 'Informatique',
            'administrateur_id' => 1,
        ]);

        Activite::create([
            'titre' => 'Exploration en laboratoire de biologie',
            'description' => 'Plongez dans le monde fascinant de la biologie à travers des expériences pratiques en laboratoire.',
            'objectifs' => 'Comprendre les principes fondamentaux de la biologie, acquérir des compétences pratiques en manipulation d échantillons biologiques et d instruments de laboratoire.',
            'image_pub' => 'biologie.jpg',
            'fiche_pdf' => 'biologie_fiche.pdf',
            'lien_youtube' => 'https://www.youtube.com/watch?v=biologievideo',
            'nbr_seances_semaine' => 2,
            'tarif' => 80.00,
            'effectif_min' => 4,
            'effectif_max' => 10,
            'effectif_actuel' => 4,
            'age_min' => 18,
            'age_max' => 99,
            'status' => 'active',
            'date_debut_etud' => '2024-09-01',
            'date_fin_etud' => '2024-12-01',
            'type_activite' => 'Laboratoire',
            'domaine_activite' => 'Biologie',
            'administrateur_id' => 1,
        ]);
        

        Activite::create([
            'titre' => 'Expériences de chimie en laboratoire',
            'description' => 'Découvrez les merveilles de la chimie à travers une série d expériences pratiques et interactives en laboratoire.',
            'objectifs' => 'Acquérir une compréhension approfondie des concepts de base de la chimie, développer des compétences en manipulation des substances chimiques et des équipements de laboratoire.',
            'image_pub' => 'chimie.jpg',
            'fiche_pdf' => 'chimie_fiche.pdf',
            'lien_youtube' => 'https://www.youtube.com/watch?v=chimievideo',
            'nbr_seances_semaine' => 2,
            'tarif' => 90.00,
            'effectif_min' => 4,
            'effectif_max' => 10,
            'effectif_actuel' => 0,
            'age_min' => 16,
            'age_max' => 99,
            'status' => 'active',
            'date_debut_etud' => '2024-09-01',
            'date_fin_etud' => '2024-12-01',
            'type_activite' => 'Laboratoire',
            'domaine_activite' => 'Chimie',
            'administrateur_id' => 1,
        ]);
        
        


        // Ajoutez d'autres activités selon vos besoins
    }
}
