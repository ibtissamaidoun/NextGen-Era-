<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MigrationTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    public function testNotificationsTable()
    {
        $this->assertTrue(Schema::hasTable('notifications'));
        $this->assertTrue(Schema::hasColumn('notifications', 'id'));
        $this->assertTrue(Schema::hasColumn('notifications', 'type'));
        $this->assertTrue(Schema::hasColumn('notifications', 'contenu'));
        $this->assertTrue(Schema::hasColumn('notifications', 'created_at'));
        $this->assertTrue(Schema::hasColumn('notifications', 'updated_at'));
    }

    public function testUserNotificationTable()
    {
        $this->assertTrue(Schema::hasTable('user_notification'));
        $this->assertTrue(Schema::hasColumn('user_notification', 'date_notification'));
        $this->assertTrue(Schema::hasColumn('user_notification', 'statut'));
        $this->assertTrue(Schema::hasColumn('user_notification', 'user_id'));
        $this->assertTrue(Schema::hasColumn('user_notification', 'notification_id'));
    }

    public function testPaiementActiviteTable()
    {
        $this->assertTrue(Schema::hasTable('paiement_activite'));
        $this->assertTrue(Schema::hasColumn('paiement_activite', 'paiement_id'));
        $this->assertTrue(Schema::hasColumn('paiement_activite', 'activite_id'));
        $this->assertTrue(Schema::hasColumn('paiement_activite', 'remise'));
    }

    public function testPaniersTable()
    {
        $this->assertTrue(Schema::hasTable('paniers'));
        $this->assertTrue(Schema::hasColumn('paniers', 'status'));
        $this->assertTrue(Schema::hasColumn('paniers', 'enfant_id'));
        $this->assertTrue(Schema::hasColumn('paniers', 'activite_id'));
        $this->assertTrue(Schema::hasColumn('paniers', 'parentmodel_id'));
    }

    public function testHorairesTable()
    {
        $this->assertTrue(Schema::hasTable('horaires'));
        $this->assertTrue(Schema::hasColumn('horaires', 'id'));
        $this->assertTrue(Schema::hasColumn('horaires', 'jour_semaine'));
        $this->assertTrue(Schema::hasColumn('horaires', 'heure_debut'));
        $this->assertTrue(Schema::hasColumn('horaires', 'heure_fin'));
        $this->assertTrue(Schema::hasColumn('horaires', 'created_at'));
        $this->assertTrue(Schema::hasColumn('horaires', 'updated_at'));
    }

    public function testHorairesDisponibiliteAnimateurTable()
    {
        $this->assertTrue(Schema::hasTable('horaires_disponibilite_animateur'));
        $this->assertTrue(Schema::hasColumn('horaires_disponibilite_animateur', 'animateur_id'));
        $this->assertTrue(Schema::hasColumn('horaires_disponibilite_animateur', 'horaire_id'));
        $this->assertTrue(Schema::hasColumn('horaires_disponibilite_animateur', 'created_at'));
        $this->assertTrue(Schema::hasColumn('horaires_disponibilite_animateur', 'updated_at'));
    }

    public function testActivitesTable()
    {
        $this->assertTrue(Schema::hasTable('activites'));
        $this->assertTrue(Schema::hasColumn('activites', 'id'));
        $this->assertTrue(Schema::hasColumn('activites', 'titre'));
        $this->assertTrue(Schema::hasColumn('activites', 'description'));
        $this->assertTrue(Schema::hasColumn('activites', 'objectifs'));
        $this->assertTrue(Schema::hasColumn('activites', 'image_pub'));
        $this->assertTrue(Schema::hasColumn('activites', 'fiche_pdf'));
        $this->assertTrue(Schema::hasColumn('activites', 'lien_youtube'));
        $this->assertTrue(Schema::hasColumn('activites', 'nbr_seances_semaine'));
        $this->assertTrue(Schema::hasColumn('activites', 'tarif'));
        $this->assertTrue(Schema::hasColumn('activites', 'effectif_min'));
        $this->assertTrue(Schema::hasColumn('activites', 'effectif_max'));
        $this->assertTrue(Schema::hasColumn('activites', 'effectif_actuel'));
        $this->assertTrue(Schema::hasColumn('activites', 'age_min'));
        $this->assertTrue(Schema::hasColumn('activites', 'age_max'));
        $this->assertTrue(Schema::hasColumn('activites', 'status'));
        $this->assertTrue(Schema::hasColumn('activites', 'date_debut_etud'));
        $this->assertTrue(Schema::hasColumn('activites', 'date_fin_etud'));
        $this->assertTrue(Schema::hasColumn('activites', 'type_activite'));
        $this->assertTrue(Schema::hasColumn('activites', 'domaine_activite'));
        $this->assertTrue(Schema::hasColumn('activites', 'administrateur_id'));
        $this->assertTrue(Schema::hasColumn('activites', 'created_at'));
        $this->assertTrue(Schema::hasColumn('activites', 'updated_at'));
    }

    public function testHorairesDisponibiliteActiviteTable()
    {
        $this->assertTrue(Schema::hasTable('horaires_disponibilite_activite'));
        $this->assertTrue(Schema::hasColumn('horaires_disponibilite_activite', 'activite_id'));
        $this->assertTrue(Schema::hasColumn('horaires_disponibilite_activite', 'horaire_id'));
        $this->assertTrue(Schema::hasColumn('horaires_disponibilite_activite', 'created_at'));
        $this->assertTrue(Schema::hasColumn('horaires_disponibilite_activite', 'updated_at'));
    }

    public function testActiviteAnimateurHoraireTable()
    {
        $this->assertTrue(Schema::hasTable('activite_animateur_horaire'));
        $this->assertTrue(Schema::hasColumn('activite_animateur_horaire', 'animateur_id'));
        $this->assertTrue(Schema::hasColumn('activite_animateur_horaire', 'activite_id'));
        $this->assertTrue(Schema::hasColumn('activite_animateur_horaire', 'horaire_id'));
        $this->assertTrue(Schema::hasColumn('activite_animateur_horaire', 'created_at'));
        $this->assertTrue(Schema::hasColumn('activite_animateur_horaire', 'updated_at'));
    }

    public function testHorairesPreferesEnfantsTable()
    {
        $this->assertTrue(Schema::hasTable('horaires_preferes_enfants'));
        $this->assertTrue(Schema::hasColumn('horaires_preferes_enfants', 'enfant_id'));
        $this->assertTrue(Schema::hasColumn('horaires_preferes_enfants', 'ordre'));
        $this->assertTrue(Schema::hasColumn('horaires_preferes_enfants', 'horaire_id'));
        $this->assertTrue(Schema::hasColumn('horaires_preferes_enfants', 'created_at'));
        $this->assertTrue(Schema::hasColumn('horaires_preferes_enfants', 'updated_at'));
    }

    public function testEmploiDeTempsTable()
    {
        $this->assertTrue(Schema::hasTable('emploi_de_temps'));
        $this->assertTrue(Schema::hasColumn('emploi_de_temps', 'enfant_id'));
        $this->assertTrue(Schema::hasColumn('emploi_de_temps', 'activite_id'));
        $this->assertTrue(Schema::hasColumn('emploi_de_temps', 'horaire_1'));
        $this->assertTrue(Schema::hasColumn('emploi_de_temps', 'horaire_2'));
        $this->assertTrue(Schema::hasColumn('emploi_de_temps', 'created_at'));
        $this->assertTrue(Schema::hasColumn('emploi_de_temps', 'updated_at'));
    }

    public function testPacksTable()
    {
        $this->assertTrue(Schema::hasTable('packs'));
        $this->assertTrue(Schema::hasColumn('packs', 'id'));
        $this->assertTrue(Schema::hasColumn('packs', 'type'));
        $this->assertTrue(Schema::hasColumn('packs', 'description'));
        $this->assertTrue(Schema::hasColumn('packs', 'remise'));
        $this->assertTrue(Schema::hasColumn('packs', 'created_at'));
        $this->assertTrue(Schema::hasColumn('packs', 'updated_at'));
    }
    public function testPaiementsTable()
    {
        $this->assertTrue(Schema::hasTable('paiements'));
        $this->assertTrue(Schema::hasColumn('paiements', 'id'));
        $this->assertTrue(Schema::hasColumn('paiements', 'option_paiement'));
        $this->assertTrue(Schema::hasColumn('paiements', 'created_at'));
        $this->assertTrue(Schema::hasColumn('paiements', 'updated_at'));
    }
    public function testResetTokensTable()
    {
        $this->assertTrue(Schema::hasTable('password_reset_tokens'));
        $this->assertTrue(Schema::hasColumns('password_reset_tokens', [
            'email', 'token', 'created_at'
        ]));
    }
    public function testFailedJobsTable()
    {
        $this->assertTrue(Schema::hasTable('failed_jobs'));

        $columns = ['id', 'uuid', 'connection', 'queue', 'payload', 'exception', 'failed_at'];
        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('failed_jobs', $column));
        }
    }
    public function testPersonalAccessTokensTable()
    {
        $this->assertTrue(Schema::hasTable('personal_access_tokens'));

        $columns = ['id', 'tokenable_type', 'tokenable_id', 'name', 'token', 'abilities', 'last_used_at', 'expires_at', 'created_at', 'updated_at'];
        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('personal_access_tokens', $column));
        }
    }
    public function testAnimateursTable()
    {
        $this->assertTrue(Schema::hasTable('animateurs'));

        $columns = ['id', 'domaine_competence', 'created_at', 'updated_at', 'user_id'];
        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('animateurs', $column));
        }
    }
    public function testParentmodelsTable()
    {
        $this->assertTrue(Schema::hasTable('parentmodels'));
        $columns = ['id', 'fonction', 'created_at', 'updated_at', 'user_id'];
        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('parentmodels', $column));
        }
    }
    public function testEnfantsTable()
    {
        $this->assertTrue(Schema::hasTable('enfants'));
        $columns = ['id', 'nom', 'prenom', 'date_de_naissance', 'niveau_etude', 'created_at', 'updated_at', 'parentmodel_id'];
        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('enfants', $column));
        }
    }
    public function AdministrateursTable()
    {
        $this->assertTrue(Schema::hasTable('administrateurs'));
        $columns = ['id', 'created_at', 'updated_at', 'user_id'];
        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('administrateurs', $column));
        }
    }
    public function testOffresTable()
    {
        $this->assertTrue(Schema::hasTable('offres'));
        $columns = ['id', 'titre', 'description', 'remise', 'created_at', 'updated_at', 'date_debut', 'date_fin', 'administrateur_id', 'paiement_id'];
        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('offres', $column));
        }
    }
    public function testDevisTable()
    {
        $this->assertTrue(Schema::hasTable('devis'));
        $columns = ['id', 'statut', 'motif_refus', 'tarif_ht', 'tarif_ttc', 'tva', 'devi_pdf', 'demande_id', 'parentmodel_id', 'created_at', 'updated_at'];
        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('devis', $column));
        }
    }
    public function testFacturesTable()
    {
        $this->assertTrue(Schema::hasTable('factures'));
        $columns = ['id', 'facture_pdf', 'devi_id'];
        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('factures', $column));
        }
    }
    public function testEnfantDemandeActiviteTable()
    {
        $this->assertTrue(Schema::hasTable('enfant_demande_activite'));
        $columns = ['created_at','updated_at','enfant_id', 'activite_id', 'demande_id'];
        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('enfant_demande_activite', $column));
        }
    }
    public function testOffreActiviteTable()
    {
        $this->assertTrue(Schema::hasTable('offre_activite'));
        $columns = ['offre_id', 'activite_id'];
        foreach ($columns as $column) {
            $this->assertTrue(Schema::hasColumn('offre_activite', $column));
        }
    }
    public function tearDown(): void
    {
        $this->artisan('migrate:rollback');
        parent::tearDown();
    }
}
