<script setup>
/* eslint-disable */

import { ref } from 'vue';
import ArgonButton from "@/components/ArgonButton.vue";

const showEmailInput = ref(false);

function toggleEmailInput() {
  showEmailInput.value = !showEmailInput.value;
}
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
          <input type="text" class="form-control" placeholder="Titre"><br/>
          <input type="text" class="form-control" placeholder="Déscription"><br/>
          <input type="text" class="form-control" placeholder="Date de début de l'inscription"><br/>
          <input type="text" class="form-control" placeholder="Date de la fin de l'inscription"><br/>
          <input type="text" class="form-control" placeholder="Option de paiment"><br/>
          <input type="text" class="form-control" placeholder="activités"><br/>
        </div>
        <div class="col-12-end text-end mt-2">
          <argon-button color="primary" variant="gradient">
            Ajouter
          </argon-button>
        </div>
      </div>
    </div>
   
</template>
