<script setup>
/* eslint-disable */

import { ref } from 'vue';
import ArgonButton from "@/components/ArgonButton.vue";

const form = ref({
  title: '',
  description: '',
  discount: '',
  startDate: '',
  endDate: '',
  paymentOption: '',
  activities: ''
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
        <input v-model="form.title" type="text" class="form-control" placeholder="Titre"><br/>
        <input v-model="form.description" type="text" class="form-control" placeholder="Déscription"><br/>
        <input v-model="form.discount" type="text" class="form-control" placeholder="Remise"><br/>
        <input v-model="form.startDate" type="text" class="form-control" placeholder="Date de début de l'inscription"><br/>
        <input v-model="form.endDate" type="text" class="form-control" placeholder="Date de la fin de l'inscription"><br/>
        <select v-model="form.paymentOption" class="form-control">
          <option disabled value="">Sélectionnez une option de paiement</option>
          <option v-for="option in paymentOptions" :key="option" :value="option">{{ option }}</option>
        </select><br/>
        <input v-model="form.activities" type="text" class="form-control" placeholder="activités"><br/>
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
