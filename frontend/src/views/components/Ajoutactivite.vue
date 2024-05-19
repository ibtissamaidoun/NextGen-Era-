<script setup>
/* eslint-disable */

import { ref } from 'vue';
import ArgonButton from "@/components/ArgonButton.vue";

const showEmailInput = ref(false);
const image = ref(null);
const pdf = ref(null);
const videoLink = ref('');

function toggleEmailInput() {
  showEmailInput.value = !showEmailInput.value;
}

function handleImageUpload(event) {
  const file = event.target.files[0];
}

function handlePdfUpload(event) {
  const file = event.target.files[0];
}

</script>

<template>
  <div>
    <div class="row">
      <div class="col-12-end text-end">
        <argon-button color="dark" variant="gradient" @click="toggleEmailInput">
          <i class="fas fa-plus"></i>
          Ajouter une activité
        </argon-button>
      </div>
    </div>

    <div v-if="showEmailInput">
      <div class="row mt-3">
        <div class="col-12-end">
          <input type="text" class="form-control" placeholder="Titre"><br/>
          <input type="text" class="form-control" placeholder="Déscription"><br/>
          <input type="text" class="form-control" placeholder="Objectifs"><br/>
          <input type="file" accept="image/*" @change="handleImageUpload" class="form-control" placeholder="Image publicitaire"><br/>
          <input type="file" accept=".pdf" @change="handlePdfUpload" class="form-control" placeholder="Fiche PDF"><br/>
          <input type="text" v-model="videoLink" class="form-control" placeholder="Lien vidéo"><br/>
          <input type="text" class="form-control" placeholder="Type d'activité"><br/>
          <input type="text" class="form-control" placeholder="Domaine d'activité"><br/>
          <input type="text" class="form-control" placeholder="Nombre de séance par semaine"><br/>
          <input type="text" class="form-control" placeholder="Tarif"><br/>
          <input type="text" class="form-control" placeholder="Effectif minimale"><br/>
          <input type="text" class="form-control" placeholder="Effectif maximale"><br/>
          <input type="text" class="form-control" placeholder="Age minimale"><br/>
          <input type="text" class="form-control" placeholder="Age maximale"><br/>
        </div>
        <div class="col-12-end text-end mt-2">
          <argon-button color="primary" variant="gradient">
            Ajouter
          </argon-button>
        </div>
      </div>
    </div>
  </div>
</template>
