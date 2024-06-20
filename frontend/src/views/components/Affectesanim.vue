<template>
  <div class="card">
    <div class="card-header pb-0 px-3">
      <h4 class="mb-2 text-center">Les activités affectées à l'animateur</h4>
    </div>
    <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center">
      <table class="table table-bordered align-items-center">
        <thead>
          <tr>
            <th class="text-uppercase text-secondary opacity-7">Atelier/Laboratoire</th>
            <th class="text-uppercase text-secondary opacity-7">Domaine d'activité</th>
            <th class="text-uppercase text-secondary opacity-7">Titre</th>
            <th class="text-secondary opacity-7">Détails</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(activity, index) in affectes" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
            <td>
              <h6 class="mb-2 text-center">{{ activity.type_activite }}</h6>
            </td>
            <td class="text-center">
              <span class="text-s">{{ activity.domaine_activite }}</span>
            </td>
            <td class="text-center">
              <span class="text-s">{{ activity.titre }}</span>
            </td>
            <td class="text-center">
              <router-link :to="`/dashboard-animateurs/Activites/details/${activity.id}`">
                <i class="fas fa-info-circle text-info"></i> Voir détails
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axios-instance'; // Ajustez le chemin si nécessaire

export default {
  data() {
    return {
      affectes: []
    };
  },
  async mounted() {
    this.fetchActivities();
  },
  methods: {
    async fetchActivities() {
      try {
        const response = await axiosInstance.get("dashboard-animateurs/activites");
        console.log(response.data.data); // Ajoutez cette ligne pour voir les données reçues
        this.affectes = response.data.data;
      } catch (error) {
        console.error('Erreur lors de la récupération des activités:', error);
      }
    },
    async deleteActivity(id, index) {
      try {
        await axiosInstance.delete(`dashboard-animateurs/activites/${id}`);
        this.affectes.splice(index, 1);
        alert('Activité supprimée avec succès');
      } catch (error) {
        console.error('Erreur lors de la suppression de l\'activité:', error);
        alert('Erreur lors de la suppression de l\'activité');
      }
    }
  }
};
</script>

<style scoped>
h4 {
  font-family: Georgia, 'Times New Roman', Times, serif;
  color: orange;
}

th {
  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  color: #000080;
}

span {
  font-family: Georgia, 'Times New Roman', Times, serif;
}
</style>