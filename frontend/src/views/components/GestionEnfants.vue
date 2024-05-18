<template>
    <div class="card">
      <div class="card-header pb-0 px-3">
        <h4 class="mb-2 text-center">Les enfants de NextGen Era</h4>
      </div>
      <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center"> 
        <table class="table table-bordered align-items-center">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary opacity-7">
                Id
              </th>
              <th class="text-uppercase text-secondary opacity-7">
                Nom
              </th>
              <th class="text-uppercase text-secondary opacity-7">
                Prénom
              </th>
              <th class="text-center text-secondary opacity-7">
                Détails
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(activity, index) in affectes" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
              <td>
                <h6 class="mb-2 text-center">{{ activity.id }}</h6>
              </td> 
              <td class="text-center">  
                <span class="text-s">{{ activity.nom }}</span>
              </td> 
              <td class="text-center">  
                <span class="text-s">{{ activity.prenom }}</span>
              </td> 
              <td class="text-center">  
                <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;">
                  <argon-button><router-link to="/dashboard-admin/Enfants/Details">Détails</router-link></argon-button>
              </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  
  <script>
  /* eslint-disable */
  
  export default {
    data() {
      return {
        affectes: [
          {
            id: "1",
            nom: "ausdu", 
            prenom: "lswefwo",
            datenaissance: "01/01/2012",
            telPortable: "0612345678",
            nivetude: "primaire",
            parentmodel:"owfjfio et ascojwm",
          },
          {
            id: "2",
            nom: "aaaaaaa", 
            prenom: "knsfskl",
            datenaissance: "04/11/2010",
            telPortable: "0612345678",
            nivetude: "college",
            parentmodel:"owfjfio et ascojwm",
          },
          {
            id: "3",
            nom: "fnklwkefn", 
            prenom: "ldddddwo",
            datenaissance: "03/03/2015",
            telPortable: "0612345678",
            nivetude: "college",
            parentmodel:"owfjfio et ascojwm",
          },
          {
            id: "4",
            nom: "ausdu", 
            prenom: "lswefwo",
            datenaissance: "03/09/2013",
            telPortable: "0612345678",
            nivetude: "college",
            parentmodel:"owfjfio et ascojwm",
          },
          {
            id: "5",
            nom: "ausdu", 
            prenom: "lswefwo",
            datenaissance: "03/09/2013",
            telPortable: "0612345678",
            nivetude: "lycee",
            parentmodel:"owfjfio et ascojwm",
          },
        ],
        selectedActivity: null,
      };
    },
  }
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
  