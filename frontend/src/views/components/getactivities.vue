<template>
    <div class="card">
      <div class="card-header   ">
        <h4 class="text-center mb-0" style="color: orange">Les activités à choisir</h4>
      </div>
      <div class="card-body px-0 pt-0 pb-0"></div>
    <div class="row py-lg-0">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <div class="col" v-for="product in products" :key="product.id">
          <div class="card shadow-sm">
            <img class="bd-placeholder img card-img-top" width="100%" :src="product.image" alt="">
            <div class="card-body">
              <router-link :to="product.path">
                <h6>{{ product.name }}</h6>
              </router-link>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" @click="toggleCart(product)" class="cart-btn btn btn-sm btn-outline-secondary me-2">
                    <span :class="isInCart(product) ? 'bi bi-cart-check' : 'bi bi-cart'">+</span>
                  </button>
                </div>
                <small class="text-muted"><i class="bi bi-currency-dollar"></i>{{ product.price }} DH</small>
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

export default {
  name: 'GetActivities',
  data() {
    return {
      products: [
        { id: 1, name: "Programmation", image: "https://interservices.fr/blog/wp-content/uploads/2019/09/apprendre-la-programmation-informatique-755x487.jpg", price: 249, path: "/Programmation" },
        { id: 2, name: "Intelligence artificielle", image: "https://f.maformation.fr/edito/sites/3/2022/03/intelligence-artificielle.jpeg", price: 399, path: "/IA" },
        { id: 3, name: "Robotique", image: "https://thetechpanda.com/wp-content/uploads/2017/10/robot-540x360.jpg", price: 399, path: "/Robotique" },
        { id: 4, name: "Calcul mental", image: "https://media.istockphoto.com/id/1066963840/fr/photo/maths-math%C3%A9matiques-formules-examen-science-id%C3%A9e-innovation-t%C3%AAte-silhouette.jpg?s=612x612&w=0&k=20&c=MuOCAf6N2sHs3MTYjgi28uusn92KNVt5fcCazGYLrHw=", price: 199, path: "/CalculMental" },
        { id: 5, name: "Laboratoire de chimie", image: "https://static7.depositphotos.com/1194063/755/i/450/depositphotos_7553989-stock-photo-scientist-working-at-the-laboratory.jpg", price: 449, path: "/LabChimie" },
        { id: 6, name: "Laboratoire de biologie", image: "https://img.freepik.com/photos-gratuite/experience-coduction-virolog-au-cours-pandemie-coronavirus-micropipette-chimiste-dans-laboratoire-moderne-faisant-recherches-aide-distributeur-pendant-epidemie-mondiale-covid-19_482257-5737.jpg", price: 449, path: "/LabBiologie" },
        { id: 7, name: "Jeux d'échecs", image: "https://img.freepik.com/photos-gratuite/concept-strategie-entreprise-jeu-echecs_53876-13385.jpg", price: 199, path: "/Echecs" },
      ],
      children: [
        { id: 1, name: "Ayoub" },
        { id: 2, name: "Taha" },
        { id: 3, name: "Anas" },
        { id: 4, name: "Sakhri" }
      ],
      selectedChild: {} // This will hold the selected child for each product
    };
  },
  computed: {
    productQty() {
      const quantities = {};
      this.products.forEach(product => {
        const cartItem = this.$store.state.cart.find(item => item.id === product.id);
        quantities[product.id] = cartItem ? cartItem.qty : 1;
      });
      return quantities;
    }
  },
  methods: {
    isInCart(product) {
      return this.$store.state.cart.some(item => item.id === product.id);
    },
    toggleCart(product) {
      const isInCart = this.isInCart(product);
      if (isInCart) {
        this.$store.commit('addRemoveCart', { product, toAdd: false });
        toast.success('Supprimer de la carte', { autoClose: 1000 });
      } else {
        product.qty = 1;
        // Add the selected child to the product here
        this.$store.commit('addRemoveCart', { product: { ...product, child: this.selectedChild[product.id] }, toAdd: true });
        toast.success('Ajouter à la carte', { autoClose: 1000 });
      }
    }
  }
};
</script>

<style>
.cart-btn {
  width: 40px;
  height: 38px;
}
h4{
    font-family: Georgia, 'Times New Roman', Times, serif;
    color:orange;
  }
</style>
