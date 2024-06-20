<template>
  <div class="row py-lg-0">
    <div class="col" v-for="(activite, index) in activites" :key="index">
      <div class="card">
        <img class="card-img-top" width="100%" sizes="200x100" :src="activite.image_pub" alt="Activity Image">
        <div class="card-body">
          <h6 class="text-center">{{ activite.titre }}</h6>
          <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
              <i class="bi bi-currency-dollar"></i>{{ activite.tarif }} DH
            </small>
            <a href="#" @click.prevent="seeMore(activite)">Détails</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axios-instance';
import 'vue3-toastify/dist/index.css';

export default {
  name: 'GetActivities',
  data() {
    return {
      activites: [],
      enfants: [],
      selectedEnfant: null,
      showDropdown: false,
      showAddBotton: true // This will hold the selected child for each product
    };
  },
  computed: {
    productQty() {
      const quantities = {};
      this.activites.forEach(product => {
        const cartItem = this.$store.state.cart.find(item => item.id === product.id);
        quantities[product.id] = cartItem ? cartItem.qty : 1;
      });
      return quantities;
    }
  },
  created() {
    this.fetchActivites();
    this.fetchEnfants();
  },
  methods: {
    async fetchActivites() {
      try {
        const response = await axiosInstance.get("/dashboard-parents/Activites");
        this.activites = response.data;
      } catch (error) {
        console.error('Error fetching activites:', error);
      }
    },
    async fetchEnfants() {
      try {
        const response = await axiosInstance.get("/dashboard-parents/Enfants");
        this.enfants = response.data.enfants;
      } catch (error) {
        console.error('Error fetching enfants:', error);
      }
    },
    isInCart(product) {
      return this.$store.state.cart.some(item => item.id === product.id);
    },
    async addToCart(activity, enfant) {
      try {
        await axiosInstance.post(`dashboard-parents/Activite/${activity.id}/add`, { enfants: [enfant.id] });
        // Handle success response
      } catch (error) {
        console.error('Error adding to cart:', error);
      }
    },
    seeMore(activite) {
      this.$router.push( {name: 'ActiviteDetail', params: { id: activite.id }});
      console.log(`See more clicked for activite ${activite.id}`);
    }
  }
};
</script>

<style>
.cart-btn {
  width: 40px;
  height: 38px;
}
h4 {
  font-family: Georgia, 'Times New Roman', Times, serif;
  color: orange;
}
</style>