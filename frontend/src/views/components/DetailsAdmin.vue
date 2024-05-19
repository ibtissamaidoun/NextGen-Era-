<template>
    <div class="card pb-0 ">

      <div class="card-header pb-5 px-3">
        <h4 class="mt-5 text-center">Les détails des administrateurs</h4>
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
              Email
            </th>
            <th class="text-center text-primary opacity-7">
              Téléphone portable
            </th>
            <th class="text-center text-primary opacity-7">
              Téléphone fixe
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
              <span class="text-s">{{ activity.email }}</span>
            </td>  
            <td class="text-center">  
              <span class="text-s">{{ activity.telPortable }}</span>
            </td> 
            <td class="text-center">  
              <span class="text-s">{{ activity.telFixe }}</span>
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
            nom: "Oulad Maalem", 
            prenom: "Ayoub",
            email: "ayoub@example.com",
            telPortable: "0612345678",
            telFixe: "0123456789",
          },
          {
            id: "4",
            nom: "Naya", 
            prenom: "Taha",
            email: "taha@example.com",
            telPortable: "0698765432",
            telFixe: "0987654321",
          },
          {
            id: "1",
            nom: "Oulad Maalem", 
            prenom: "Ayoub",
            email: "ayoub@example.com",
            telPortable: "0612345678",
            telFixe: "0123456789",
          },
          {
            id: "4",
            nom: "Naya", 
            prenom: "Taha",
            email: "taha@example.com",
            telPortable: "0698765432",
            telFixe: "0987654321",
          },
          {
            id: "1",
            nom: "Oulad Maalem", 
            prenom: "Ayoub",
            email: "ayoub@example.com",
            telPortable: "0612345678",
            telFixe: "0123456789",
          },
          {
            id: "4",
            nom: "Naya", 
            prenom: "Taha",
            email: "taha@example.com",
            telPortable: "0698765432",
            telFixe: "0987654321",
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
  