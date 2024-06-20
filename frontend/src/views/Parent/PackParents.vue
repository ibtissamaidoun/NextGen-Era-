<template>
  <div class="card pb-8">
    <div class="alert alert-success" v-if="showSuccessMessage">
      <p>{{ successMessage }}</p>
    </div>
    <div class="container mt-5">
      <div class="row">
        <div class="card-header pb-3 px-3">
          <h2 class="mb-2 text-center">Choisir un pack</h2>
        </div>
      </div>
      <div>
        <div v-for="(pack, index) in packs" :key="index" class="row justify-content-center mt-4 pt-2">
          <a class="col-lg-6 mb-4 pt-2 d-flex" @click="selectPack(pack.id)">
            <div class="card pack-card flex-fill">
              <div class="card-body">
                <h4 class="card-title pack-title">PACK {{ pack.type.toUpperCase() }}</h4>
                <p class="pack-description">
                  {{ pack.description }}
                </p>
                <p class="pack-description">
                  Remise : {{ pack.remise }} %
                </p>
              </div>
            </div>
          </a>
        </div>
      </div>
      <!-- Section pour choisir l'option de paiement -->
      <div v-if="selectedPack">
  <h2 class="mb-2 text-center">Option de paiement:</h2>
  <div v-for="(Op, index) in OPs" :key="index" class="row justify-content-center mt-4">
    <div class="col-lg-6 mb-4 pt-2 d-flex">
      <div class="card pack-card flex-fill" @click="selectPayment(Op.id)">
        <div class="card-body">
          <h5 class="card-title pack-title">{{ Op.option_paiement }}</h5>
        </div>
      </div>
    </div>
  </div>
  <!-- Affichage du bouton Valider seulement si un pack est sélectionné -->
  <div v-if="selectedPayment">
    <div class="row justify-content-center mt-4">
      <div class="d-grid gap-2">
        <!-- to="/dashboard-parents/Demandes/overview" -->
        <button class="btn btn-primary" @click="nextStep()">Suivant</button>
      </div>
    </div>
  </div>
</div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axios-instance';

export default {
  data() {
    return {
      packIds: [],
      packs: [],
      OPs: [],
      paiements:[],
      selectedPack: null,
      selectedPayment: null,
      showSuccessMessage: false,
      successMessage: ''
    };
  },
  computed: {
    demandeId() {
      return this.$route.params.demandeId;
    }
  },
  created() {
    this.getData();
  },
  methods: {
    async getData() {
  try {
    const validation = await axiosInstance.get(`dashboard-parents/Demandes/${this.demandeId}/check`);
    this.packIds = validation.data.packPoussible;

    const response1 = await axiosInstance.get('dashboard-parents/packs');
    this.packs = response1.data;
    this.packs = this.packs.filter(pack => this.packIds.some(idObj => idObj.id === pack.id));

    const response2 = await axiosInstance.get('dashboard-parents/paiements');
    this.OPs = response2.data;
    this.paiements = this.OPs.map(option => ({
          option_id: option.id,
          option_paiement: option.option_paiement}));
    console.log("Payment Options:", this.OPs); // Add this line
  } catch (error) {
    console.log(error);
  }
},


    displaySuccessMessage(message) {
      this.successMessage = message;
      this.showSuccessMessage = true;
      setTimeout(() => {
        this.showSuccessMessage = false;
      }, 3000); // hide the message after 3 seconds
    },

    async selectPack(id) {
    try {
    const response = await axiosInstance.post(`dashboard-parents/Demandes/${this.demandeId}/pack`, { pack: id });
    this.displaySuccessMessage(response.data.message);
    this.selectedPack = id; // Ensure selectedPack is set to the pack id

    console.log("Selected Pack:", this.selectedPack); // Add this line
  } catch (error) {
    console.log(error);
  }
  
}


    ,async selectPayment(id) {
      try {
        const response = await axiosInstance.post(`dashboard-parents/Demandes/${this.demandeId}/OP`, { optionPaiement: id });
        this.displaySuccessMessage(response.data.message);
        this.selectedPayment = id; // Ensure selectedPayment is set to the payment id
        console.log("Payment Options:", this.OPs); // Add this line

      } catch (error) {
        console.log(error);
      }
    },

    async nextStep() {
      try {
        const res = await axiosInstance.post(`dashboard-parents/Demandes/${this.demandeId}/submit`);
        this.displaySuccessMessage(res.data.message);
        this.$router.push({ name: 'devis', params: { demandeId: this.demandeId } });
      } catch (error) {
        console.error('Error submitting request:', error);
        if (error.response && error.response.data && error.response.data.message) {
          this.displayErrorMessage(error.response.data.message);
        } else {
          this.displayErrorMessage('An error occurred while submitting the request. Please try again.');
        }
      }
    },

    displayErrorMessage(message) {
      // Implement a method to display error messages
      alert(message);
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

/* Card Container */
.pack-card {
  background: #f8f9fa;
  border: 2px solid #dee2e6;
  border-radius: 1rem;
  transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

/* Card Hover Effect */
.pack-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
}

/* Card Title */
.pack-title {
  margin-bottom: 1rem;
  font-weight: bold;
}

/* Card Description */
.pack-description {
  font-size: 1rem;
  color: #6c757d;
  margin-bottom: 0.5rem;
}

/* Card Link Styling */
a {
  text-decoration: none;
  color: inherit;
}

/* Responsive Padding */
@media (max-width: 768px) {
  .pack-card {
    margin-bottom: 1.5rem;
  }
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
.alert {
  position: fixed;
  top: 70px;
  left: 80%;
  z-index: 1000;
  border-radius: 5px;
  color: #ffffff;
  display: flex;
  justify-content: center;
  align-items: center;
}

.alert-success {
  color: #ffffff;
}
</style>
