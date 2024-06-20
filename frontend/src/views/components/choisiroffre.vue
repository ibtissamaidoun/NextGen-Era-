<template>
  <div class="container">
    <div class="card-header pb-3 px-3">
      <h3 class="mb-2 text-center">Choisir une offre</h3>
    </div>
    <div class="row mt-5">
      <div class="col-md-6" v-for="offer in offres" :key="offer.id">
        <div class="card shadow-lg">
          <div class="card-header bg-success text-white">
            <h3 class="mb-2 text-center">{{ offer.titre }}</h3>
            <span v-if="offer.remise > 0" class="badge bg-warning">Remise: {{ offer.remise }}%</span>
          </div>
          <div class="card-body pt-2">
            <p>{{ offer.description }}</p>
            <router-link :to="{ name: 'OffreDetails', params: { id: offer.id } }" class="btn btn-success mt-3">Détails</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axios-instance'; // Ensure axios is correctly imported

export default {
  data() {
    return {
      offres: [],
      enfants: []
    };
  },
  methods: {
    fetchAllData() {
      axiosInstance.get('dashboard-parents/Offres')
        .then(response => {
          this.offres = response.data.offres;
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    }
  },
  created() {
    this.fetchAllData();
  }
};
</script>

<style scoped>
.container {
  max-width: 1200px;
  margin: auto;
  margin-top: 20px;
}
.card {
  margin-bottom: 20px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
}
.card-header {
  border-radius: 10px 10px 0 0;
}
.card-body {
  background-color: #ffffff;
  padding: 20px;
}
</style>
