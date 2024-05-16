<template>
  <div class="card">
    <div class="card-header pb-0" >
      <h4 class="text-center mb-4">Emploi des activités</h4>
    </div>
    <div class="card-body px-0 pt-0 pb-2" style="padding:100%">
      <div class="table-responsive p-0">
      <table class="table align-items-center mb-0">
        <thead>
          <tr >
            <th  class="text-uppercase text-secondary opacity-7">Heures</th>
            <th v-for="(day, index) in days" :key="index"  class="text-uppercase text-secondary opacity-7">{{ day }}</th>
          </tr>
        </thead>
        <tbody >
          <tr v-for="(hour, hourIndex) in hours" :key="hourIndex" class="bg-gray-100">
            <h6> <td class="align-middle text-center">{{ hour }}</td> </h6>
            <td v-for="(day, dayIndex) in days" :key="dayIndex">
              
              <template v-for="(activity,index) in activities" :key="index">
                <template v-if="activity.day === day && activity.Time === hour" >
                  <div>
                    <p>{{ activity.title }}</p>
                    <p>{{ activity.domain }}</p>
                  </div>
                </template>
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
export default {
  data() {
    return {
      days: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"],
      hours: ["09:00-10:30", "10:30-12:00", "12:00-13:30", "13:30-15:00", "15:00-16:30", "16:30-18:00","18:00-19:30","19:30-21:00","21:00-22:30"],
      activities: [
        {
          title: "cours de Programmation",
          domain: "informatique",
          day: "Lundi",
          Time: "10:30-12:00",
        },
        {
          title: "Laboratoire de chimie",
          domain: "Sciences et éducation",
          day: "Vendredi",
          Time: "12:00-13:30",
        },
        {
          title: "Atelier de Yoga",
          domain: "Sportif",
          day: "Jeudi",
          Time: "09:00-10:30",
        },
        {
          title: "Laboratoire de chimie",
          domain: "Sciences et éducation",
          day: "Vendredi",
          Time: "15:00-16:30",
        },
        {
          title: "Atelier de Yoga",
          domain: "Sportif",
          day: "Lundi",
          Time: "09:00-10:30",
        },
        {
          title: "Atelier de tech",
          domain: "Sportif",
          day: "Mardi",
          Time: "09:00-10:30",
        },
        {
          title: "Atelier de foot",
          domain: "Sportif",
          day: "Samedi",
          Time: "09:00-10:30",
        },
        {
          title: "Atelier de samadi",
          domain: "Sportif",
          day: "Dimanche",
          Time: "18:00-19:30",
        },
        {
          title: "competitive programming",
          domain: "informatique",
          day: "Lundi",
          Time: "18:00-19:30",
        },
        {
          title: "exemple",
          domain: "informatique",
          day: "Mercredi",
          Time: "21:00-22:30",
        },
        {
          title: "exemple",
          domain: "informatique",
          day: "Mardi",
          Time: "21:00-22:30",
        },
      ]
    };
  }
};
</script>

<style scoped>
  h4{
    font-family: Georgia, 'Times New Roman', Times, serif;
    color:orange;
  }
  h6{
    font-family: Georgia, 'Times New Roman', Times, serif;
    color:#000080;
  }
  p{
    font-family:Georgia, 'Times New Roman', Times, serif;
    

  }

  </style>
