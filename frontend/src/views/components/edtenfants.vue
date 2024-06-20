<template>
  <div class="card">
    <div class="card-header pb-0">
      <h4 class="text-center mb-4">Emploi des activités</h4>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
      <div class="table-responsive p-0">
        <table class="table table-bordered align-items-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary opacity-7">Heures</th>
              <th v-for="(day, index) in days" :key="index" class="text-uppercase text-secondary opacity-7">{{ day }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(hour, hourIndex) in hours" :key="hourIndex" class="bg-gray-100">
              <td class="align-middle text-center">{{ hour }}</td>
              <td v-for="(day, dayIndex) in days" :key="dayIndex">
                <template v-for="(activity, index) in activities[hourIndex][dayIndex]" :key="index">
                  <div>
                    <p>{{ activity.title }}</p>
                    <p>{{ activity.domain }}</p>
                  </div>
                </template>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axios-instance'; // Assurez-vous que le chemin est correct

export default {
  data() {
    return {
      days: [],
      hours: [],
      activities: []
    };
  },
  created() {
    this.fetchEDT();
  },
  methods: {
    fetchEDT() {
      axiosInstance.get('/dashboard-animateurs/edt')
        .then(response => {
          this.activities = this.processEDT(response.data);
        })
        .catch(error => {
          console.error("Erreur lors de la récupération de l'emploi du temps:", error);
        });
    },
    processEDT(data) {
      // Initialiser un tableau vide pour chaque cellule de temps
      let edt = Array(this.hours.length).fill().map(() => Array(this.days.length).fill([]));

      // Remplir le tableau avec les activités correspondantes
      data.forEach(activity => {
        let hourIndex = this.hours.findIndex(hour => hour === `${activity.heureDebut}-${activity.heureFin}`);
        let dayIndex = this.days.findIndex(day => day === activity.jour);

        if (hourIndex !== -1 && dayIndex !== -1) {
          edt[hourIndex][dayIndex].push({
            title: activity.titre,
            domain: activity.domaine,
            day: activity.jour,
            Time: `${activity.heureDebut}-${activity.heureFin}`
          });
        }
      });

      return edt;
    }
  }
};
</script>

<style scoped>
h4 {
  font-family: Georgia, 'Times New Roman', Times, serif;
  color: orange;
}
h6 {
  font-family: Georgia, 'Times New Roman', Times, serif;
  color: #000080;
}
p {
  font-family: Georgia, 'Times New Roman', Times, serif;
}
</style>
