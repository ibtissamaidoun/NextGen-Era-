<template>
  <div>
    <div>
      <h4 class="mb-2 text-center">Les offres disponibles</h4>
    </div>
    <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center"> 
      <table class="table table-bordered align-middle">
        <thead>
          <tr>
            <th class="text-uppercase text-primary opacity-7">id</th>
            <th class="text-uppercase text-primary opacity-7">Titre</th>
            <th class="text-uppercase text-primary opacity-7">Remise</th>
            <th class="text-uppercase text-primary opacity-7">Date de début d'inscription</th>
            <th class="text-uppercase text-primary opacity-7">Date de la fin d'inscription</th>
            <th class="text-center text-primary opacity-7">Supprimer</th>
            <th class="text-center text-primary opacity-7">Editer</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(offre, index) in offres" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
            <td><h6 class="text-center">{{ offre.id}}</h6></td>
            <td><h6 class="mb-2 text-center">{{ offre.titre}}</h6></td>
            <td><h6 class="mb-2 text-center">{{ offre.remise}}</h6></td>
            <td><h6 class="mb-2 text-center">{{ offre.date_debut}}</h6></td>
            <td><h6 class="mb-2 text-center">{{ offre.date_fin}}</h6></td>
            <td class="text-center">
              <button class="btn btn-link text-danger text-gradient px-3 mb-0" @click="deleteOffre(offre.id, index)">
                <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
              </button>
            </td>
            <td class="align-middle">
              <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;">
                <argon-button>
                  <router-link to="/dashboard-admin/Offres/Editer">
                    <i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>
                  </router-link>
                </argon-button>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped>
h4 {
  font-family: Georgia, 'Times New Roman', Times, serif;
  color: orange;
}
h6 {
  font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
  color: #000080;
}
th {
  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  color: #000080;
}
span {
  font-family: Georgia, 'Times New Roman', Times, serif;
}
</style>

<script>
import axiosInstance from '@/axios-instance';

export default {
  data() {
    return {
      offres: []
    };
  },
  mounted() {
    this.fetchOffres();
  },
  methods: {
    async fetchOffres() {
      try {
        const response = await axiosInstance.get('/dashboard-admin/offres');
        this.offres = response.data.offre;
        console.log(response.data);
      } catch (error) {
        console.error('Erreur lors de la récupération des offres:', error);
      }
    },
    async deleteOffre(offre_id, index) {
      try {
        await axiosInstance.delete(`/dashboard-admin/offres/${offre_id}`);
        this.offres.splice(index, 1);
      } catch (error) {
        console.error('Erreur lors de la suppression de l\'offre:', error);
      }
    }
  }
};
</script>