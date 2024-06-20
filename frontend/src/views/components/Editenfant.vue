<script setup>
/* eslint-disable */

import { ref, onMounted } from 'vue';
import { useRoute ,useRouter } from 'vue-router';
import ArgonButton from "@/components/ArgonButton.vue";
import axiosInstance from '@/axios-instance';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const route = useRoute();
const router = useRouter();
const enfantId = ref(route.params.id);

const form = ref({
 
  nom:'',  
  prenom: '',
  date_naissance: '',
  niveau_etude: '',
  
});
onMounted(async () => {
  try {
    let response = await axiosInstance.get(`dashboard-parents/Enfants/${enfantId.value}`);
    const data = response.data;
    form.value.nom = data.nom;
    form.value.prenom = data.prenom;
    form.value.date_naissance = data.date_naissance;
    form.value.niveau_etude = data.niveau_etude;
    console.log(response.data);
  } catch (error) {
    console.error('Erreur lors du chargement des données:', error);
  }
});

const submitForm = async () => {
  try {
    let response = await axiosInstance.put(`dashboard-parents/Enfants/${enfantId.value}`, {
      nom: form.value.nom,
      prenom: form.value.prenom,
      date_de_naissance: form.value.date_naissance,
      niveau_etude: form.value.niveau_etude
    });
    toast.success('Modification effectuée avec succès!'); 
    router.back();
    console.log('Réponse du serveur:', response.data);
  } catch (error) {
    if (error.response && error.response.data) {
      console.error('Erreur:', error.response.data);
      toast.error('Erreur lors de la modification: ' + JSON.stringify(error.response.data)); // Affichage du message d'erreur
    } else {
      console.error('Erreur:', error.message);
      toast.error('Erreur lors de la modification'); // Affichage du message d'erreur
    }
  }
};


</script>

<template>
  <div class="card mt-6">
    <div class="card-header pb-0 px-3"></div>
    
      <div class="col-12-end">
        <input v-model="form.nom" type="text" class="form-control" placeholder="NOM"><br/>
        <input v-model="form.prenom" type="text" class="form-control" placeholder="PRENOM"><br/>
        <input v-model="form.date_naissance" type="text" class="form-control" placeholder="DATE DE NAISSANCE"><br/>
        <input v-model="form.niveau_etude" type="text" class="form-control" placeholder="NIVEAU D'ETUDE"><br/>

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