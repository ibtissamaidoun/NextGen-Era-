<template>
  <div class="card">
    <div class="card-header pb-0 px-3">
      <h4 class="mb-2 text-center">La gestion des Activités</h4>
    </div>
    <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center">
      <table class="table table-bordered align-items-center">
        <thead>
          <tr>
            <th class="text-uppercase text-primary opacity-7">Id</th>
            <th class="text-uppercase text-primary opacity-7">Titre</th>
            <th class="text-uppercase text-primary opacity-7">Type d'activité</th>
            <th class="text-center text-primary opacity-7">Domaine d'activité</th>
            <th class="text-center text-primary opacity-7">Détails</th>
            <th class="text-center text-primary opacity-7">Supprimer</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(activity, index) in activities" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
            <td>
              <h6 class="mb-2 text-center">{{ activity.id }}</h6>
            </td>
            <td class="text-center">
              <span class="text-s">{{ activity.titre }}</span>
            </td>
            <td class="text-center">
              <span class="text-s">{{ activity.type_activite }}</span>
            </td>
            <td class="text-center">
              <span class="text-s">{{ activity.domaine_activite }}</span>
            </td>
            <td class="text-center">
              <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;">
                <argon-button><router-link :to="`/dashboard-admin/Activites/Details/${activity.id}`">Détails</router-link></argon-button>
              </a>
            </td>
            <td class="text-center">
              <button class="btn btn-link text-danger text-gradient px-3 mb-0" @click="deleteActivity(activity.id)">
                <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
              </button>
            </td>
            
           
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
/* eslint-disable */
import axiosInstance from '@/axios-instance';

export default {
  data() {
    return {
      activities: [],
    };
  },
  methods: {
    async fetchData() {
      try {
        const response = await axiosInstance.get('/dashboard-admin/Activites');
        this.activities = response.data;
      } catch (error) {
        console.error('Error fetching activities:', error);
      }
    },
    async deleteActivity(id) {
      try {
        await axiosInstance.delete(`/dashboard-admin/Activites/${id}`);
        this.fetchData(); // Refresh the list after deletion
      } catch (error) {
        console.error('Error deleting activity:', error);
      }
    },
    
  },
  mounted() {
    this.fetchData();
  },
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

.alert {
  padding: 15px;
  margin: 10px 0;
  border: 1px solid transparent;
  border-radius: 4px;
}

.success {
  background-color: #d4edda;
  color: #155724;
  border-color: #c3e6cb;
}
.small {
  font-size: 0.8em;
}
</style>