<template>
  <section class="h-100 h-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col">
          <div class="card border-0">
            <div class="card-body p-4">
              <div class="row">
                <div class="col-lg-7">
                  <h5 class="mb-3">
                    <router-link :to="{ name: 'ActivitesParents' }" class="text-body">
                      <i class="fas fa-long-arrow-alt-left me-2"></i> Continue l'achat
                    </router-link>
                  </h5>
                  <hr />
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="text-align-center">
                      <h5 class="mb-0" style="color: orange;">Tu as {{ panier.length }} elements dans votre panier</h5>
                    </div>
                  </div>

                  <div v-for="(item, index) in panier" class="card mb-3 shadow-sm border-0" :key="index">
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                        <div class="d-flex flex-row align-items-center">
                          <div class="ms-3">
                            <h5
                              style="
                                font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode',
                                  Geneva, Verdana, sans-serif;
                                color: #000080;
                              "
                            >
                              {{ item.Activite.titre }}
                            </h5>
                          </div>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                          <button @click="showDetails(index)" class="ms-4 btn btn-link text-secondary">Voir détails</button>
                          <button class="btn btn-danger" @click="deleteActivite(item.Activite.id)">Supprimer</button>
                      </div>
                      </div>
                    </div>
                    <div v-if="showDetailsTab[index]">
                              <table
                                class="table table-striped table-bordered"
                                style="width: 100%; overflow: hidden;"
                              >
                                <thead>
                                  <tr>
                                    <th>Enfants</th>
                                    <th>Remplacer</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(child, index2) in item.Enfants" :key="index2">
                                    <td>{{ child.nom }} {{ child.prenom }}</td>
                                    <td>
                                      <div class="dropdown">
                                        <button
                                          @click="showDropDown[index][index2] = !showDropDown[index][index2]"
                                          class="btn btn-link text-primary dropdown-toggle"
                                          type="button"
                                          >
                                        </button>
                                        <div v-if="showDropDown[index][index2]">
                                            <form v-for="enfant in enfants" :key="enfant.id">
                                                    <button v-if="enfant.id != child.id" class="dropdown-item" @click="showDropDown[index][index2] = !showDropDown[index][index2]; replaceChild(item.Activite.id ,child.id, enfant.id)">
                                                      {{ enfant.nom }} {{ enfant.prenom }}
                                                    </button>
                                            </form>
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                  </div>
                </div>
                <div class="col-lg-5">
                  <div class="card text-white rounded-3 border-0" style="background-color:royalblue">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 style="color: white;">ACTIONS SUR LA CARTE</h5>
                        <i class="bi bi-cart3 h1"></i>
                      </div>
                      <hr class="my-4" />
                      <div>
                        <a @click="validerPanier()"  type="button" class="btn btn-info btn-block" style="margin-inline: 5%; padding-inline: 5%; padding-block: 3%; ">
                          Demander
                        </a>
                        <a @click="supprimerPanier()" to="/dashboard-parents/Activites" type="button" class="btn btn-warning btn-block" style="margin-inline: 5%; padding-block: 3%; padding-inline: 5%;">
                          Vider le Panier
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>




<script>
import axiosInstance from '@/axios-instance';
import 'vue3-toastify/dist/index.css';

export default {
  data() {
  return {
      panier: [],
      showDetailsTab: [],
      enfants: [],
      showDropDown: [],
  };
  },
  computed: {
      
  },
  created() {
  this.getData();

  },
  methods:{
      async getData() {
      try {
      const responce1 = await axiosInstance.get("dashboard-parents/panier/show");
      this.panier = responce1.data.Panier;
      this.showDetailsTab = new Array(this.panier.length).fill(false);
      this.showDropDown = this.panier.map(item => new Array(item.Enfants.length).fill(false));

      const responce2 = await axiosInstance.get('/dashboard-parents/Enfants');
      this.enfants = responce2.data.enfants;
      } catch (error) {
          console.error('Error fetching data:', error);
      }
  },
  deleteActivite(activite) {
      axiosInstance.delete(`dashboard-parents/panier/activites/${activite}`);
  },

  async replaceChild(activity_id ,child_id, enfant_id) {
     await axiosInstance.put(`dashboard-parents/panier/activite/${activity_id}/enfants/${child_id}`,{ enfant: enfant_id} );
  },

  async validerPanier() {
      const responce = await axiosInstance.get('dashboard-parents/panier/valide');
      alert(responce.data.message);
      this.$router.push({name: 'pack' , params: { demandeId: responce.data.demande_id }});
  },
  async supprimerPanier() {
      const responce = await axiosInstance.delete('dashboard-parents/panier/delete');
      alert(responce.data.message);
  },
  

  showDetails(index) {
  // Show the details of the selected item
  console.log(index);
  // You can also toggle a boolean flag to show/hide the details section
  this.showDetailsTab[index] = !this.showDetailsTab[index];
  }
  }
};
</script>

<style>
.card {
  margin-bottom: 20px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border: none;
}
.card-body {
  padding: 20px;
}
.d-flex {
  display: flex;
  align-items: center;
}
.justify-content-between {
  justify-content: space-between;
}
.ms-3 {
  margin-left: 3px;
}
.ms-4 {
  margin-left: 4px;
}
h5 {
  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  color: #000080;
  margin-bottom: 10px;
}
.table {
  width: 100%;
  margin-bottom: 20px;
}
.table th, .table td {
  padding: 10px;
  border: 1px solid #ddd;
}
.table th {
  background-color: #f0f0f0;
}
.btn-link {
  color: #337ab7;
  text-decoration: none;
}
.btn-link:hover {
  color: #23527c;
  text-decoration: underline;
}
.text-secondary {
  color: #6c757d;
}
.text-danger {
  color: #dc3545;
}
</style>