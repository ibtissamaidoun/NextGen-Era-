<script setup>
/* eslint-disable */

import { ref } from 'vue';
import ArgonButton from "@/components/ArgonButton.vue";
import axiosInstance from '@/axios-instance';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const showEmailInput = ref(false);
const nom = ref('');
const prenom = ref('');
const dateDeNaissance = ref('');
const niveauEtude = ref('');


function toggleEmailInput() {
  showEmailInput.value = !showEmailInput.value;
}
function ajouterEnfant() {
  const enfantData = {
    nom: nom.value,
    prenom: prenom.value,
    date_de_naissance: dateDeNaissance.value,
    niveau_etude: niveauEtude.value,
  };

  axiosInstance.post('/dashboard-parents/Enfants', enfantData)
    .then(response => {
      toast.success('Enfant créé avec succès');
      // Vous pouvez également mettre à jour l'état ou effectuer d'autres actions ici
    })
    .catch(error => {
      if (error.response && error.response.data) {
        console.error('Erreur lors de la création de l\'enfant:', error.response.data);
        toast.error('Erreur lors de la création de l\'enfant: ' + JSON.stringify(error.response.data));
      } else {
        console.error('Erreur lors de la création de l\'enfant:', error.message);
        toast.error('Erreur lors de la création de l\'enfant');
      }
    });;
}
</script>

<template>
  <div>
    <div class="row">
      <div class="col-12-end text-end">
        <argon-button color="dark" variant="gradient" @click="toggleEmailInput">
          <i class="fas fa-plus"></i>
          Ajouter un enfant
        </argon-button>
      </div>
    </div>

    <div v-if="showEmailInput">
      <div class="row mt-3">
        <div class="col-12-end">
          <input type="text" class="form-control" placeholder="Nom" v-model="nom"><br/>
          <input type="text" class="form-control" placeholder="PRÉNOM" v-model="prenom"><br/>
          <input type="text" class="form-control" placeholder="DATE DE NAISSANCE" v-model="dateDeNaissance"><br/>
          <input type="text" class="form-control" placeholder="NIVEAU D'ÉTUDE" v-model="niveauEtude"><br/>
        </div>
        <div class="col-12-end text-end mt-2">
          <argon-button color="primary" variant="gradient" @click="ajouterEnfant">
            Ajouter
          </argon-button>
        </div>
      </div>
    </div>
  </div>
</template>