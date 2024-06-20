<template>
  <div>
    <div class="row">
      <div class="col-12-end text-end">
        <argon-button color="dark" variant="gradient" @click="toggleEmailInput">
          <i class="fas fa-plus"></i>
          Ajouter l'horaire
        </argon-button>
      </div>
    </div>

    <div v-if="showEmailInput">
      <div class="row mt-3">
        <div class="col-12-end">
          <input v-model="heureDebut" type="text" class="form-control" placeholder="Heure début">
          <input v-model="heureFin" type="text" class="form-control" placeholder="Heure fin">
          <select v-model="jourSemaine" class="form-control">
            <option disabled value="">Sélectionnez le jour</option>
            <option>Lundi</option>
            <option>Mardi</option>
            <option>Mercredi</option>
            <option>Jeudi</option>
            <option>Vendredi</option>
            <option>Samedi</option>
            <option>Dimanche</option>
          </select>
        </div>
        <div class="col-12-end text-end mt-2">
          <argon-button @click="submitHoraire" color="primary" variant="gradient">
            Ajouter
          </argon-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axios-instance';
import ArgonButton from "@/components/ArgonButton.vue";

export default {
  components: {
    ArgonButton
  },
  data() {
    return {
      showEmailInput: false,
      heureDebut: '',
      heureFin: '',
      jourSemaine: ''
    };
  },
  methods: {
    toggleEmailInput() {
      this.showEmailInput = !this.showEmailInput;
    },
    async submitHoraire() {
      try {
        const payload = {
          heure_debut: this.heureDebut,
          heure_fin: this.heureFin,
          jour_semaine: this.jourSemaine
        };
        const response = await axiosInstance.post('/dashboard-admin/horaires', payload);
        console.log('Horaire ajouté avec succès:', response.data);
       
        this.resetForm();
      } catch (error) {
        console.error('Erreur complète:', error);
      }
    },
    resetForm() {
      this.heureDebut = '';
      this.heureFin = '';
      this.jourSemaine = '';
      this.showEmailInput = false;
    }
  }
}
</script>