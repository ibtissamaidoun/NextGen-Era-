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
      <div class="col-12-end text-end">
        <argon-button color="dark" variant="gradient" @click="toggleEmailInput">
          <i class="fas fa-plus"></i>
          Ajouter un animateur
        </argon-button>
      </div>
    </div>

    <div v-if="showEmailInput">
      <div class="row mt-3">
        <div class="col-12-end">
          <input type="email" class="form-control" placeholder="Email">
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
