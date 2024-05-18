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
  <div>
    <div class="row">
      <div class="col-12-end text-right">
        <argon-button color="dark" variant="gradient" @click="toggleEmailInput">
          <i class="fas fa-plus"></i>
          Ajouter un animateur
        </argon-button>
      </div>
    </div>

    <div v-if="showEmailInput">
      <div class="row mt-3">
        <div class="col-12-end">
          <input type="text" class="form-control" placeholder="id"><br/>
          <input type="text" class="form-control" placeholder="Nom"><br/>
          <input type="text" class="form-control" placeholder="Prénom"><br/>
          <input type="text" class="form-control" placeholder="Email"><br/>
          <input type="password" class="form-control" placeholder="password"><br/>
          <input type="text" class="form-control" placeholder="Téléphone portable"><br/>
          <input type="text" class="form-control" placeholder="Téléphone fix">
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
