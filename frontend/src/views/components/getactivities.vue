<template>
  <div class="card">
    <div class="card-header">
      <h4 class="text-center mb-0" style="color: orange">Les activités à choisir</h4>
    </div>
    <div class="card-body px-0 pt-0 pb-0">
      <div class="row py-lg-0">
        <div class="col-12">
          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <!-- Liste des activités -->
            <div class="col" v-for="product in products" :key="product.id">
              <div class="card shadow-sm">
                <img class="bd-placeholder img card-img-top" width="100%" :src="product.image" :alt="product.name">
                <div class="card-body">
                  <router-link :to="product.path">
                    <h6>{{ product.name }}</h6>
                  </router-link>
                  <div class="d-flex justify-content-between align-items-center">
                   
                      
                     
                      
                    <div class="btn-group">
                      <button type="button" @click="toggleCart(product)" class="cart-btn btn btn-sm btn-outline-secondary">
                        <span :class="isInCart(product) ? 'bi bi-cart-check' : 'bi bi-cart'">+</span>
                      </button>
                      <div>
                      <select v-model="selectedChild[product.id]" id="childSelect" class="form-select " @change="childSelected(product)">
                        <option disabled value="">Sélectionner un enfant</option>
                        <option v-for="child in children" :key="child.id" :value="child">{{ child.name }}</option>
                      </select>
                      </div>
                    </div>
                    <small class="text-muted"><i class="bi bi-currency-dollar"></i>{{ product.price }} DH</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import axiosInstance from '@/axios-instance';

export default {
  name: 'GetActivities',
  data() {
    return {
      products: [],
      children: [],
      selectedChild: {} // Utilisé pour stocker l'enfant sélectionné pour chaque produit
    };
  },
  mounted() {
    this.loadActivities();
    this.loadChildren();
  },
  methods: {
    loadActivities() {
      axiosInstance.get('/dashboard-parents/Activites')
        .then(response => {
          this.products = response.data.map(activity => ({
            id: activity.id,
            name: activity.titre,
            image: activity.image_pub,
            price: activity.tarif,
            path: `/activity/${activity.id}`
          }));
        })
        .catch(error => {
          console.error('Erreur lors du chargement des activités:', error);
          toast.error('Erreur lors du chargement des activités');
        });
    },
    loadChildren() {
      // Exemple de chargement des enfants, remplacez cela avec votre propre logique
      this.children = [
        { id: 1, name: "Ayoub" },
        { id: 2, name: "Taha" },
        { id: 3, name: "Anas" },
        { id: 4, name: "Sakhri" }
      ];
    },
    isInCart(product) {
      return this.$store.state.cart.some(item => item.id === product.id);
    },
    toggleCart(product) {
      const isInCart = this.isInCart(product);
      if (isInCart) {
        this.$store.commit('addRemoveCart', { product, toAdd: false });
        toast.success('Supprimé du panier', { autoClose: 1000 });
      } else {
        if (!this.selectedChild[product.id]) {
          toast.error('Veuillez sélectionner un enfant');
          return;
        }
        product.qty = 1;
        this.$store.commit('addRemoveCart', { product: { ...product, child: this.selectedChild[product.id] }, toAdd: true });
        toast.success('Ajouté au panier', { autoClose: 1000 });
      }
    },
    childSelected(product) {
      console.log('Enfant sélectionné pour', product.name, ':', this.selectedChild[product.id]);
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
