<script setup>
import { ref } from 'vue';
import axiosInstance from "@/axios-instance"; 
import ArgonButton from "@/components/ArgonButton.vue";

let showEmailInput = ref(false);
let email = ref('');
let adminCreated = ref(false);

function toggleEmailInput() {
  showEmailInput.value = !showEmailInput.value;
}

async function addAdministrator() {
  try {
    const response = await axiosInstance.post('dashboard-admin/admins', { email: email.value });
    if (response.status === 200) {
      console.log('Admin created successfully');
      adminCreated.value = true;
    } else if (response.status === 409) {
      console.log('Admin already exists in the database');
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
          Ajouter un administrateur
        </argon-button>
      </div>
    </div>

    <div v-if="showEmailInput">
      <div class="row mt-3">
        <div class="col-12-end">
          <input type="email" class="form-control" placeholder="Email" v-model="email">
        </div>
        <div class="col-12-end text-end mt-2">
          <argon-button color="primary" variant="gradient" @click="addAdministrator">
            Ajouter
          </argon-button>
        </div>
      </div>
    </div>

    <div v-if="adminCreated" class="notification success">
      Admin created successfully!
    </div>
  </div>
</template>

<style>
.notification.success {
  background-color: #d4edda;
  color: #155724;
  padding: 10px;
  margin-top: 10px;
  border: 1px solid #c3e6cb;
  border-radius: 5px;
}
</style>