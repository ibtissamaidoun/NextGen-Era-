<script setup>
/* eslint-disable */

import { ref } from 'vue';
import ArgonButton from "@/components/ArgonButton.vue";

const form = ref({
  heure_debut: '',
  heure_fin: '',
  jour_semaine: '',
});

const paymentOptions = ref(['Mensuel', 'Annuel']);

const submitForm = () => {
  console.log('Form data:', form.value);
};
</script>

<template>
  <div class="card mt-6">
    <div class="card-header pb-0 px-3"></div>
    
      <div class="col-12-end">
        <input v-model="form.title" type="text" class="form-control" placeholder="Heure de début"><br/>
        <input v-model="form.description" type="text" class="form-control" placeholder="Heure de la fin"><br/>
        <input v-model="form.discount" type="text" class="form-control" placeholder="Jour de semaine"><br/>
      </div>
      <div class="col-12-end text-end mt-2">
        <argon-button color="primary" variant="gradient" @click="submitForm">
          Editer
        </argon-button>
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
