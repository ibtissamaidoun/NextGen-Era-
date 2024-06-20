<template>
  <div>
    <div class="row">
      <div class="col-12-end text-end">
        <argon-button color="dark" variant="gradient" @click="toggleEmailInput">
          <i class="fas fa-plus"></i> Ajouter une activité
        </argon-button>
      </div>
    </div>

    <div v-if="showEmailInput">
      <div class="row mt-3">
        <div class="col-12-end">
          <input v-model="titre" type="text" class="form-control" placeholder="Titre">
          <textarea v-model="description" class="form-control" placeholder="Description"></textarea>
          <textarea v-model="objectifs" class="form-control" placeholder="Objectifs"></textarea>
          <input v-model="nbrSeancesSemaine" type="number" class="form-control" placeholder="Nombre de séances par semaine">
          <input v-model="tarif" type="number" class="form-control" placeholder="Tarif">
          <input v-model="effectifMin" type="number" class="form-control" placeholder="Effectif minimal">
          <input v-model="effectifMax" type="number" class="form-control" placeholder="Effectif maximal">
          <input v-model="ageMin" type="number" class="form-control" placeholder="Âge minimal">
          <input v-model="ageMax" type="number" class="form-control" placeholder="Âge maximal">
          <input v-model="dateDebutEtud" type="date" class="form-control" placeholder="Date de début">
          <input v-model="dateFinEtud" type="date" class="form-control" placeholder="Date de fin">
          <input v-model="lienYoutube" type="text" class="form-control" placeholder="Lien YouTube">
          <input v-model="typeActivite" type="text" class="form-control" placeholder="Type d'activité">
          <input v-model="domaineActivite" type="text" class="form-control" placeholder="Domaine d'activité">
          <div class="mb-3">
            <label for="horaire1">Choisissez le premier horaire:</label>
            <select v-model="selectedHoraire1" class="form-control">
              <option v-for="horaire in formattedHoraires" :key="horaire.id" :value="horaire.id">
                {{ horaire.label }}
              </option>
            </select>
          </div>
          <div class="mb-3">
            <label for="horaire2">Choisissez le deuxième horaire:</label>
            <select v-model="selectedHoraire2" class="form-control">
              <option v-for="horaire in formattedHoraires" :key="horaire.id" :value="horaire.id">
                {{ horaire.label }}
              </option>
            </select>
          </div>
          <div v-for="(paiement, index) in paiements" :key="index" class="mb-3">
            <label :for="'paiement-' + paiement.option_id">{{ paiement.option_paiement }}</label>
            <input type="number" v-model="paiement.remise" class="form-control" :id="'paiement-' + paiement.option_id" placeholder="Remise (%)">
          </div>
          <input type="file" @change="handleImageUpload" class="form-control" placeholder="Image publicitaire">
          <input type="file" @change="handlePdfUpload" class="form-control" placeholder="Fiche PDF">
          <input type="number" v-model="effectifActuel" class="form-control" placeholder="Effectif actuel">
          <argon-button @click="submitActivity" color="primary" variant="gradient">
            Ajouter
          </argon-button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axiosInstance from '@/axios-instance';
import ArgonButton from "@/components/ArgonButton.vue";

export default {
  components: {
    ArgonButton
  },
  data() {
    return {
      showEmailInput: false,
      titre: '',
      description: '',
      objectifs: '',
      nbrSeancesSemaine: '',
      tarif: '',
      effectifMin: '',
      effectifMax: '',
      ageMin: '',
      ageMax: '',
      dateDebutEtud: '',
      dateFinEtud: '',
      lienYoutube: '',
      typeActivite: '',
      domaineActivite: '',
      paiements: [],
      availableOptions: [],
      image: null,
      pdf: null,
      effectifActuel: 0,
      horaires: [],
      formattedHoraires: [],
      selectedHoraire1: null,
      selectedHoraire2: null,
    };
  },
  methods: {
    toggleEmailInput() {
      this.showEmailInput = !this.showEmailInput;
    },
    async loadPaymentOptions() {
      try {
        const response = await axiosInstance.get('/dashboard-admin/paiements');
        this.availableOptions = response.data;
        this.paiements = this.availableOptions.map(option => ({
          option_id: option.id,
          option_paiement: option.option_paiement,
          remise: 0
        }));
      } catch (error) {
        console.error('Failed to load payment options:', error);
        this.availableOptions = [];
        this.paiements = [];
      }
    },
    handleImageUpload(event) {
      this.image = event.target.files[0];
    },
    handlePdfUpload(event) {
      this.pdf = event.target.files[0];
    },
    async submitActivity() {
      const formData = new FormData();
      formData.append('titre', this.titre);
      formData.append('description', this.description);
      formData.append('objectifs', this.objectifs);
      formData.append('nbr_seances_semaine', this.nbrSeancesSemaine);
      formData.append('tarif', this.tarif);
      formData.append('effectif_min', this.effectifMin);
      formData.append('effectif_max', this.effectifMax);
      formData.append('age_min', this.ageMin);
      formData.append('age_max', this.ageMax);
      formData.append('date_debut_etud', this.dateDebutEtud);
      formData.append('date_fin_etud', this.dateFinEtud);
      formData.append('lien_youtube', this.lienYoutube);
      formData.append('type_activite', this.typeActivite);
      formData.append('domaine_activite', this.domaineActivite);
      formData.append('effectif_actuel', this.effectifActuel);
      this.paiements.forEach((paiement, index) => {
        formData.append(`option_paiement[${index}]`, paiement.option_id);
        formData.append(`remise[${index}]`, paiement.remise);
      });
      if (this.image) {
        formData.append('image_pub', this.image);
      }
      if (this.pdf) {
        formData.append('fiche_pdf', this.pdf);
      }

      try {
        const response = await axiosInstance.post('/dashboard-admin/Activites', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        if (response.data && response.data.activity && response.data.activity.id) {
          const activityId = response.data.activity.id;
          const horaireIds = [this.selectedHoraire1, this.selectedHoraire2].filter(id => id != null);
          await this.associateHoraires(activityId, horaireIds);
          this.confirmationMessage = 'L\'activité a été ajoutée et associée avec succès aux horaires.';
          this.resetForm();
        } else {
          this.confirmationMessage = 'Erreur lors de la création de l\'activité.';
          console.error('Activity ID is undefined after creation:', response.data);
        }
      } catch (error) {
        console.error('Erreur lors de lajout de lactivité:', error);
      }
    },
    resetForm() {
      this.titre = '';
      this.description = '';
      this.objectifs = '';
      this.nbrSeancesSemaine = '';
      this.tarif = '';
      this.effectifMin = '';
      this.effectifMax = '';
      this.ageMin = '';
      this.ageMax = '';
      this.dateDebutEtud = '';
      this.dateFinEtud = '';
      this.lienYoutube = '';
      this.typeActivite = '';
      this.domaineActivite = '';
      this.effectifActuel = 0;
      this.image = null;
      this.pdf = null;
      this.selectedHoraire1 = null;
      this.selectedHoraire2 = null;
      this.showEmailInput = false;
    },
    loadHoraires() {
      axiosInstance.get('/dashboard-admin/horaires')
        .then(response => {
          this.horaires = response.data;
          this.formatHoraires();
        })
        .catch(error => {
          console.error("Failed to load horaires:", error);
        });
    },
    formatHoraires() {
      this.formattedHoraires = this.horaires.map(h => ({
        id: h.id,
        label: `${h.heure_debut.slice(0, 5)}-${h.heure_fin.slice(0, 5)}-${h.jour_semaine}`
      }));
    },
    async associateHoraires(activityId, horaireIds) {
      for (const horaireId of horaireIds) {
        try {
          await axiosInstance.post(`/dashboard-admin/Activites/${activityId}/horaires`, { horaire_id: horaireId });
          console.log(`Horaire ${horaireId} associé avec succès à l'activité ${activityId}`);
        } catch (error) {
          console.error(`Erreur lors de l'association de l'horaire ${horaireId} à l'activité ${activityId}:`, error);
        }
      }
      this.confirmationMessage = 'Les horaires ont été correctement associés à lactivité.';
    },
  },
  created() {
    this.loadPaymentOptions();
    this.loadHoraires();
  }
}
</script>