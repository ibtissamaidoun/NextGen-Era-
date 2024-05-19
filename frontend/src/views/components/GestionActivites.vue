<template>
    <div class="card">
      <div class="card-header pb-0 px-3">
        <h4 class="mb-2 text-center">La gestion des Parents</h4>
      </div>
      <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center"> 
        <table class="table table-bordered align-items-center">
          <thead>
            <tr>
              <th class="text-uppercase text-primary opacity-7">
                Id
              </th>
              <th class="text-uppercase text-primary opacity-7">
                Titre
              </th>
              <th class="text-uppercase text-primary opacity-7">
                Type d'activité
              </th>
              <th class="text-center text-primary opacity-7">
                Domaine d'activité
              </th>
              <th class="text-center text-primary opacity-7">
                Détails
              </th>
              <th
                class="text-center  text-primary  opacity-7"
              >
                Supprimer
              </th>
              
              <th class="text-center text-primary opacity-7"> Editer</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(activity, index) in affectes" :key="index" class="p-4 mb-2 bg-gray-100 border-radius-lg">
              <td>
                <h6 class="mb-2 text-center">{{ activity.id }}</h6>
              </td> 
              <td class="text-center">  
                <span class="text-s">{{ activity.titre }}</span>
              </td> 
              <td class="text-center">  
                <span class="text-s">{{ activity.typeactivite }}</span>
              </td> 
              <td class="text-center">  
                <span class="text-s">{{ activity.domaineactivite }}</span>
              </td> 
              
              <td class="text-center">  
                <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;">
                  <argon-button><router-link to="/dashboard-admin/Activites/Details">Détails</router-link></argon-button>
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
            titre: "Oulad Maalem", 
            typeactivite: "Ayoub",
            domaineactivite: "ayoub@example.com",
          },
          {
            id: "1",
            titre: "Oulad Maalem", 
            typeactivite: "Ayoub",
            domaineactivite: "ayoub@example.com",
          },
          {
            id: "1",
            titre: "Oulad Maalem", 
            typeactivite: "Ayoub",
            domaineactivite: "ayoub@example.com",
          },
          {
            id: "1",
            titre: "Oulad Maalem", 
            typeactivite: "Ayoub",
            domaineactivite: "ayoub@example.com",
          },
          {
            id: "1",
            titre: "Oulad Maalem", 
            typeactivite: "Ayoub",
            domaineactivite: "ayoub@example.com",
          },
          {
            id: "1",
            titre: "Oulad Maalem", 
            typeactivite: "Ayoub",
            domaineactivite: "ayoub@example.com",
          },
          {
            id: "1",
            titre: "Oulad Maalem", 
            typeactivite: "Ayoub",
            domaineactivite: "ayoub@example.com",
          },
        ],
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
  