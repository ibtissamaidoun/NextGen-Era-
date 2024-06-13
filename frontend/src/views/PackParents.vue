<template>
  <div class="card pb-8">
    <div class="container mt-5">
      <div class="row">
        <div class="card-header pb-3 px-3">
          <h2 class="mb-2 text-center">Choisir un pack</h2>
        </div>
      </div>
      <div class="row justify-content-center mt-4 pt-2"> <h4>Types de packs:</h4>
        <div class="col-lg-6 mb-4 pt-2 d-flex">
          <div class="card pack-card flex-fill" @click="selectPack('ateliers')">
            <div class="card-body">
              <h4 class="card-title pack-title">PACK BASIQUE</h4>
              <p class="pack-description">
                Ce pack est pour vous si vous avez un seul enfant pour une activité unique.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-4 d-flex">
          <div class="card pack-card flex-fill" @click="selectPack('enfants')">
            <div class="card-body">
              <h4 class="card-title pack-title">PACK  MULTI-ACTIVITES</h4>
              <p class="pack-description">
                Ce pack est pour vous si vous avez un seul enfant pour plusieurs activités. 
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-4 d-flex">
          <div class="card pack-card flex-fill" @click="selectPack('enfants')">
            <div class="card-body">
              <h4 class="card-title pack-title">PACK  FAMILIAL</h4>
              <p class="pack-description">
                Ce pack est pour vous si vous avez un plusieurs enfants pour une seule activité. 
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Section pour choisir l'option de paiement -->
      <div v-if="selectedPack"> <h4>option de paiement: </h4>
        <div class="row justify-content-center mt-4">
          <div class="col-lg-6 mb-4 pt-2 d-flex">
            <div class="card pack-card flex-fill" @click="selectPayment('mensuel')">
              <div class="card-body">
                <h5 class="card-title pack-title">Paiement Mensuel</h5>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-4 d-flex">
            <div class="card pack-card flex-fill" @click="selectPayment('annuel')">
              <div class="card-body">
                <h5 class="card-title pack-title">Paiement annuel</h5>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-4 d-flex">
            <div class="card pack-card flex-fill" @click="selectPayment('semestriel')">
              <div class="card-body">
                <h5 class="card-title pack-title">Paiement semestriel</h5>
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-4 d-flex">
            <div class="card pack-card flex-fill" @click="selectPayment('trimestriel')">
              <div class="card-body">
                <h5 class="card-title pack-title">Paiement trimestriel</h5>
              </div>
            </div>
          </div>
          <!-- Ajout des autres options de paiement ici -->
        </div>
        <!-- Affichage du bouton Valider seulement si un pack est sélectionné -->
        <div v-if="selectedPayment">
          <div class="row justify-content-center mt-4">
            <div class="d-grid gap-2">
              <router-link to="/dashboard-parents/Demandes/overview" class="btn btn-primary " type="button">
                Valider
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      selectedPack: null,
      selectedPayment: null
    };
  },
  methods: {
    selectPack(pack) {
      this.selectedPack = pack;
    },
    selectPayment(payment) {
      this.selectedPayment = payment;
    }
  }
};
</script>

<style scoped>
.container {
  max-width: 1000px;
  margin: auto;
}

.card-header h2 {
  font-family: 'Georgia', 'Times New Roman', Times, serif;
  color: orange;
}

.pack-title {
  font-family: 'Georgia', 'Times New Roman', Times, serif;
  color: #000080;
}

.pack-description {
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 16px;
  color: #333;
}

.pack-card {
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.pack-card:hover {
  transform: translateY(-5px);
}

.card-body {
  padding: 20px;
  flex-grow: 1;
}

.d-flex {
  display: flex;
}

.flex-fill {
  flex: 1;
}
</style>
