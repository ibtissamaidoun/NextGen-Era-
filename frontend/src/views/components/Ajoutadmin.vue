<script setup>
import { ref } from 'vue';
import axiosInstance from "@/axios-instance"; // Make sure this is correctly imported
import ArgonButton from "@/components/ArgonButton.vue";

const email = ref('');
const showEmailInput = ref(false);

function toggleEmailInput() {
  showEmailInput.value = !showEmailInput.value;
}

async function addAdministrator() {
  let trimmedEmail = email.value.trim();
  if (!trimmedEmail) {
    alert('Please enter a valid email address.');
    return;
  }

  console.log("Attempting to add email:", trimmedEmail); // Debug: Log the email being sent

  try {
    const response = await axiosInstance.post('admins', { email: trimmedEmail });
    console.log("Response:", response); // Debug: Log the response
    alert('Administrator added successfully: ' + response.data.message);
    email.value = '';
  } catch (error) {
    console.error('Error adding administrator:', error.response ? error.response.data.message : error.message);
    alert('Failed to add administrator: ' + (error.response ? error.response.data.message : error.message));
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
          <input type="email" class="form-control" placeholder="Email">
        </div>
        <div class="col-12-end text-end mt-2">
          <argon-button color="primary" variant="gradient" @click="addAdministrator">
            Ajouter
          </argon-button>
        </div>
      </div>
    </div>
  </div>
</template>`  `