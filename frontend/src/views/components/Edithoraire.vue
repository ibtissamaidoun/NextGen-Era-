<script>
import axiosInstance from '@/axios-instance';

export default {
  data() {
    return {
      form: {
        heure_debut: '',
        heure_fin: '',
        jour_semaine: ''
      },
      heureId: null
    };
  },
  mounted() {
    this.heureId = this.$route.params.heureId; // Assurez-vous que le nom du paramètre est correct
    console.log("Heure ID récupéré:", this.heureId); // Pour le débogage
  },
  methods: {
    submitForm() {
      console.log("Données envoyées pour la mise à jour:", this.form);
      if (!this.form.heure_debut || !this.form.heure_fin || !this.form.jour_semaine) {
        alert('Veuillez remplir tous les champs correctement.');
        return;
      }
      axiosInstance.put(`/dashboard-admin/horaires/Editer/${this.heureId}`, this.form)
        .then(response => {
          alert('Horaire mis à jour avec succès');
          console.log('Réponse de mise à jour:', response.data);
        })
        .catch(error => {
  console.error('Erreur lors de la mise à jour de l\'horaire:', error);
  let errorMessage = "Une erreur inconnue est survenue";
  if (error.response) {
    console.log("Détails de l'erreur:", error.response);
    errorMessage = error.response.data && error.response.data.message
                   ? error.response.data.message
                   : error.response.statusText;
  } else if (error.message) {
    errorMessage = error.message;
  }
  alert(`Erreur lors de la mise à jour: ${errorMessage}`);
});

    }
  }
}
</script>

<template>
  <div class="card mt-6">
    <div class="col-12">
      <input v-model="form.heure_debut" type="time" class="form-control" placeholder="Heure début">
      <input v-model="form.heure_fin" type="time" class="form-control" placeholder="Heure fin">
      <select v-model="form.jour_semaine" class="form-control">
        <option disabled value="">Choisissez un jour</option>
        <option>Lundi</option>
        <option>Mardi</option>
        <option>Mercredi</option>
        <option>Jeudi</option>
        <option>Vendredi</option>
        <option>Samedi</option>
        <option>Dimanche</option>
      </select>
      <button @click="submitForm" class="btn btn-primary mt-2">Editer</button>
    </div>
  </div>
</template>

<style scoped>
.card {
  margin-top: 20px;
  padding: 20px;
}
.btn-primary {
  width: 100%;
}
.form-control {
  margin-bottom: 10px;
}
</style>