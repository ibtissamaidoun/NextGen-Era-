<template>
  <div class="card">
    <div class="card-header pb-0 px-3">
      <h4 class="mb-2 text-center">La gestion des animateurs</h4>
    </div>

    <div class="card-body pt-4 p-3 text-center justify-content-center align-items-center"> 
      <table class="table table-bordered align-items-center">
        <thead>
          <tr>
            <th class="text-uppercase text-primary opacity-7">
              Id
            </th>
            <th class="text-uppercase text-primary opacity-7">
              Nom
            </th>
            <th class="text-uppercase text-primary opacity-7">
              Prénom
            </th>
            <th class="text-center text-primary opacity-7">
              Supprimer
            </th>
            <th class="text-center text-primary opacity-7">
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
                <i class="far fa-trash-alt me-2" aria-hidden="true"></i>
              </a>
            </td>
            <td class="text-center">  
              <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;">
                <argon-button><router-link to="/dashboard-admin/Animateurs/Details">Détails</router-link></argon-button>
            </a>
            </td>
          </tr>
        </tbody>
      </table>

    <div class="card-body px-0 pt-0 pb-2">
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th
                class="text-uppercase text-secondary opacity-7"
              >
                Animateurs
              </th>
              <th
                class="text-center  text-secondary  opacity-7"
              >
               telephone_portable
              </th>
              <th
                class="text-center  text-secondary  opacity-7"
              >
                date_creation
              </th>
              
              <th class="text-secondary opacity-7"> Editer</th>
              <th class="text-secondary opacity-7">Supprimer</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <div class="d-flex px-2 py-1 align-items-center">
                  <div>
                    <img
                      src="../../assets/img/team-2.jpg"
                      class="avatar avatar-sm me-3"
                      alt="user1"
                    />
                  </div>
                  <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">John Michael</h6>
                    <p class="text-xs text-secondary mb-0">
                      john@creative-tim.com
                    </p>
                  </div>
                </div>
              </td>
              
              <td class="align-middle text-center text-sm">
                <span class="badge badge-sm bg-gradient-success">En ligne</span>
              </td>
              <td class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold"
                  >23/04/18</span
                >
              </td>
              <td class="align-middle">
                <a
                  href="javascript:;"
                  class="text-secondary font-weight-bold text-xs"
                  data-toggle="tooltip"
                  data-original-title="Edit user"
                  >Edit</a
                >
              </td>
              <td class="align-middle">
                <a
                  href="javascript:;"
                  class="text-secondary font-weight-bold text-xs"
                  data-toggle="tooltip"
                  data-original-title="Edit user"
                  >Delete</a
                >
              </td>
            </tr>
       
          </tbody>
        </table>
      </div>

    </div>
    
  </div>
</template>




<script>
/* eslint-disable */
import ArgonButton from '@/components/ArgonButton.vue';

export default {
  data() {
    return {
      affectes: [
        {
          id: "1",
          nom: "Oulad Maalem", 
          prenom: "Ayoub",
          email: "ayoub@example.com",
          telPortable: "0612345678",
          telFixe: "0123456789",
          domaineCompetence: "Informatique",
          horaire: "9h - 17h",
        },
        {
          id: "4",
          nom: "Naya", 
          prenom: "Taha",
          email: "taha@example.com",
          telPortable: "0698765432",
          telFixe: "0987654321",
          domaineCompetence: "Finance",
          horaire: "8h - 16h",
        },
        {
          id: "1",
          nom: "Oulad Maalem", 
          prenom: "Ayoub",
          email: "ayoub@example.com",
          telPortable: "0612345678",
          telFixe: "0123456789",
          domaineCompetence: "Informatique",
          horaire: "9h - 17h",
        },
        {
          id: "4",
          nom: "Naya", 
          prenom: "Taha",
          email: "taha@example.com",
          telPortable: "0698765432",
          telFixe: "0987654321",
          domaineCompetence: "Finance",
          horaire: "8h - 16h",
        },
        {
          id: "1",
          nom: "Oulad Maalem", 
          prenom: "Ayoub",
          email: "ayoub@example.com",
          telPortable: "0612345678",
          telFixe: "0123456789",
          domaineCompetence: "Informatique",
          horaire: "9h - 17h",
        },
        {
          id: "4",
          nom: "Naya", 
          prenom: "Taha",
          email: "taha@example.com",
          telPortable: "0698765432",
          telFixe: "0987654321",
          domaineCompetence: "Finance",
          horaire: "8h - 16h",
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

//<script setup>
//import { ref } from "vue";
//import axiosInstance from '@/main';
//import { onBeforeMount } from 'vue';
//const Animateurs= ref( [nom,prenom,email,telephone_fixe]); //ref pour creer var

//onBeforeMount(async() => {
  // let response= await axiosInstance.get('/admin/animateurs');
   //console.log(response);

 // code to DB
});


//</script>

