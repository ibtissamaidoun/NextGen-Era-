<script setup>
/* eslint-disable */

import { ref } from 'vue';
import ArgonButton from "@/components/ArgonButton.vue";
import axiosInstance from "@/axios-instance"; // Import axiosInstance

let email = ref(''); // Declare email as a ref
let adminCreated = ref(false); // Declare adminCreated as a ref

const showEmailInput = ref(false);

function toggleEmailInput() {
  showEmailInput.value = !showEmailInput.value;
}

async function addAnimator() {
  try {
    const response = await axiosInstance.post('dashboard-admin/animateurs', { email: email.value });
    if (response.status === 200) {
      console.log('Animateur created successfully');
      adminCreated.value = true;
    } else if (response.status === 409) {
      console.log('Animator already exists in the database');
    }
  } catch (error) {
    console.error('An error occurred:', error);
  }
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
          <input type="email" class="form-control" placeholder="Email" v-model="email"> <!-- Add v-model to bind email input -->
        </div>
        <div class="col-12-end text-end mt-2">
          <argon-button color="primary" variant="gradient" @click="addAnimator"> <!-- Add @click event to call addAnimator function -->
            Ajouter
          </argon-button>
        </div>
      </div>
    </div>

    <div v-if="adminCreated" class="notification success">
      Animateur created successfully!
    </div>
  </div>
</template>