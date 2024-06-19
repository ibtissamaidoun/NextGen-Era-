<script setup>
/* eslint-disable */

import { ref , onMounted } from 'vue';
import { useRouter } from 'vue-router';
import ArgonButton from "@/components/ArgonButton.vue";
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css';
import axiosInstance from '@/axios-instance';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const router = useRouter();
const offerId = ref(router.currentRoute.value.params.id);

const form = ref({
  title: '',
  description: '',
  discount: '',
  startDate: '',
  endDate: '',
  selectedPaiementId: null,
  selectedActivites: []
});

const paiementOptions = ref([]);
const activites = ref([]);

async function fetchOfferDetails() {
  try {
    const response = await axiosInstance.get(`dashboard-admin/offres/${offerId.value}`);
    const data = response.data;
    form.value.titre = data.titre;
    form.value.description = data.description;
    form.value.dateDebut = data.date_debut;
    form.value.dateFin = data.date_fin;
    form.value.remise = data.remise;
    form.value.selectedPaiementId = paiementOptions.value.find(p => p.id === data.paiement_id);
    form.value.selectedActivites = activites.value.filter(a => data.activites.includes(a.id));
  } catch (error) {
    console.error('Erreur lors du chargement des détails de l\'offre:', error);
  }
}
async function fetchPaiementOptions() {
  try {
    const response = await axiosInstance.get('dashboard-admin/paiements');
    paiementOptions.value = response.data.map(p => ({ id: p.id, option_paiement: p.option_paiement }));
  } catch (error) {
    console.error('Erreur lors du chargement des options de paiement:', error);
  }
}
async function fetchActivites() {
  try {
    const response = await axiosInstance.get('dashboard-admin/Activites');
    activites.value = response.data;
  } catch (error) {
    console.error('Erreur lors du chargement des activités:', error);
  }
}
onMounted(() => {
  fetchPaiementOptions();
  fetchActivites();
  fetchOfferDetails();
});

const submitForm = async () => {
  try {
    const response = await axiosInstance.patch(`dashboard-admin/offres/${offerId.value}`, {
      titre: form.value.titre,
      description: form.value.description,
      date_debut: form.value.dateDebut,
      date_fin: form.value.dateFin,
      paiement_id: form.value.selectedPaiementId.id,
      activites: form.value.selectedActivites.map(a => ({ id: a.id })),
      remise: form.value.remise
    });
    toast.success('Offre mise à jour avec succès!');
    router.back();
  } catch (error) {
    console.error('Erreur lors de la mise à jour de l\'offre:', error);
    toast.error('Erreur lors de la mise à jour de l\'offre: ' + error.message);
  }
};

</script>

<template>
  <div class="card mt-6">
    <div class="card-header pb-0 px-3"></div>
    
      <div class="col-12-end">
        <input type="text" class="form-control" placeholder="Titre" v-model="form.titre"><br/>
      <input type="text" class="form-control" placeholder="Description" v-model="form.description"><br/>
      <input type="text" class="form-control" placeholder="Date de début de l'inscription" v-model="form.dateDebut"><br/>
      <input type="text" class="form-control" placeholder="Date de la fin de l'inscription" v-model="form.dateFin"><br/>
      <input type="number" class="form-control" placeholder="Remise (%)" v-model="form.remise"><br/>
      <multiselect 
        v-model="form.selectedPaiementId" 
        :options="paiementOptions" 
        :multiple="false"  
        placeholder="Sélectionnez une option de paiement"
        label="option_paiement"
        track-by="id"
      ></multiselect>
      <label for="activites-select">Sélectionnez une ou plusieurs activités :</label>
      <multiselect 
        v-model="form.selectedActivites" 
        :options="activites" 
        :multiple="true" 
        :taggable="true"
        placeholder="Choisissez des activités"
        label="titre" 
        track-by="id">
      </multiselect>
      <div class="col-12-end text-end mt-2">
        <argon-button color="primary" variant="gradient" @click="submitForm">
          Editer
        </argon-button>
      </div>
  </div>
</div>
</template>

<style scoped>
.card {
  margin-top: 20px;
}

.card-header {
  padding-bottom: 0;
  padding-left: 15px;
  padding-right: 15px;
}

.card-body {
  padding-top: 20px;
  padding-left: 15px;
  padding-right: 15px;
  text-align: center;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.form-control {
  margin-bottom: 10px;
}

.text-end {
  text-align: end;
}

.mt-4 {
  margin-top: 1.5rem;
}

.mt-2 {
  margin-top: 0.5rem;
}
</style>