<script setup>
/* eslint-disable */

import { ref , onMounted ,onUnmounted } from 'vue';
import ArgonButton from "@/components/ArgonButton.vue";
import axiosInstance from '@/axios-instance';
import Multiselect from 'vue-multiselect';
import 'vue-multiselect/dist/vue-multiselect.css';
import { watch } from 'vue';
const showEmailInput = ref(false);
const titre = ref('');
const description = ref('');
const dateDebut = ref('');
const dateFin = ref('');
const remise = ref('');
const activites = ref([]);
const selectedActivites = ref([]);
const paiementOptions = ref([]);
const selectedPaiementId = ref(null);

//charger les activites disponibles
async function fetchActivites() {
  try {
    const response = await axiosInstance.get('dashboard-admin/Activites');
    activites.value = response.data;
    console.log("Activités chargées:", activites.value); // Ajoutez cette ligne pour déboguer
  } catch (error) {
    console.error('Erreur lors du chargement des activités:', error);
  }
}

onMounted(fetchActivites);
onUnmounted(fetchActivites);
async function fetchPaiementOptions() {
  try {
    const response = await axiosInstance.get('dashboard-admin/paiements');
    paiementOptions.value = response.data;
    console.log(paiementOptions.value); 
  } catch (error) {
    console.error('Erreur lors du chargement des options de paiement:', error);
  }
}
onMounted(fetchPaiementOptions);
onUnmounted(fetchPaiementOptions);
function toggleEmailInput() {
  showEmailInput.value = !showEmailInput.value;
}
// async function ajouterOffre() {
//   try {
//     const response = await axiosInstance.post('dashboard-admin/offres', {
//       titre: titre.value,
//       description: description.value,
//       date_debut: dateDebut.value,
//       date_fin: dateFin.value,
//       paiement_id: paiementId.value,
//       activites: activites.value.map(activite => ({ id: activite }))//activites: activites.value.map(id => ({ id }))
//     });
//     console.log(response.data);
//     alert('Offre ajoutée avec succès');
//   } catch (error) {
//     console.error('Erreur lors de l\'ajout de l\'offre:', error);
//     alert('Erreur lors de l\'ajout de l\'offre');
//   }
// }
async function ajouterOffre() {
  console.log('Activités à envoyer:', selectedActivites.value.map(a => a.id));
 // const activiteIds = selectedActivites.value.map(activite => activite.id);
  const activiteIds = selectedActivites.value.map(activite => ({ id: activite.id }));
  console.log('Données à envoyer:', {
       titre: titre.value,
       description: description.value,
       date_debut: dateDebut.value,
       date_fin: dateFin.value,
       paiement_id: selectedPaiementId.value.id,
       activites: selectedActivites.value.map(activite => activite.id)
     });

   
  if (!titre.value || !description.value || !dateDebut.value || !dateFin.value ||  !selectedPaiementId.value || selectedActivites.value.length === 0|| !remise.value) {
    alert('Veuillez remplir tous les champs requis.');
    return;
  }

  try {
    const response = await axiosInstance.post('dashboard-admin/offres', {
      titre: titre.value,
      description: description.value,
      date_debut: dateDebut.value,
      date_fin: dateFin.value,
      paiement_id: selectedPaiementId.value.id,
      activites: activiteIds,
      remise: remise.value 
    });
    
    alert('Offre ajoutée avec succès');
  } catch (error) {
    console.error("Erreur lors de l'ajout de l'offre:", error.response);
    alert('Erreur lors de l\'ajout de l\'offre');
  }
}
// axiosInstance.post('dashboard-admin/offres', offreData)
//     .then(response => {
//       console.log("Réponse du serveur:", response.data);
//       alert('Offre ajoutée avec succès');
//     })
//     .catch(error => {
//       console.error("Erreur lors de l'ajout de l'offre:", error.response);
//       alert("Erreur lors de l'ajout de l'offre");
//     });
//   }

watch(selectedPaiementId, (newVal, oldVal) => {
  console.log('selectedPaiementId changed:', newVal);
}, { deep: true });

watch(selectedActivites, (newVal, oldVal) => {
     console.log('selectedActivites changed:', newVal);
   }, { deep: true });

</script>

<template>
 
    <div class="row">
      <div class="col-12-end text-right">
        <argon-button color="dark" variant="gradient" @click="toggleEmailInput">
          <i class="fas fa-plus"></i>
          Ajouter l'offre
        </argon-button>
      </div>
    </div>

    <div v-if="showEmailInput">
      <div class="row mt-3">
        <div class="col-12-end">
          <input type="text" class="form-control" placeholder="Titre" v-model="titre"><br/>
          <input type="text" class="form-control" placeholder="Déscription" v-model="description"><br/>
          <input type="text" class="form-control" placeholder="Date de début de l'inscription" v-model="dateDebut"><br/>
          <input type="text" class="form-control" placeholder="Date de la fin de l'inscription" v-model="dateFin"><br/>
          <input type="number" class="form-control" placeholder="Remise (%)" v-model="remise"><br/>
          <multiselect 
            v-model="selectedPaiementId" 
            :options="paiementOptions" 
            :multiple="false"  
            placeholder="Sélectionnez une option de paiement"
            label="option_paiement"
            track-by="id"
          ></multiselect>
          <label for="activites-select">Sélectionnez une ou plusieurs activités :</label>
        <multiselect 
          v-model="selectedActivites" 
          :options="activites" 
          :multiple="true" 
          :taggable="true"
          placeholder="Choisissez des activités"
          label="titre" 
          track-by="id">
        </multiselect>
        </div>
        <div class="col-12-end text-end mt-2">
          <argon-button color="primary" variant="gradient" @click="ajouterOffre">
            Ajouter
          </argon-button>
        </div>
      </div>
    </div>
   
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>