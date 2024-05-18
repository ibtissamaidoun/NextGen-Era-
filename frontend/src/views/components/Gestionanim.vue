<template>
  <div class="card">
    <div class="card-header pb-0">
      <h6 class="text-center">Gestion des Animateurs</h6>
    </div>
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
<script setup>
//import { ref } from "vue";
import axiosInstance from '@/main';
import { onBeforeMount } from 'vue';
//const Animateurs= ref( [nom,prenom,email,telephone_fixe]); //ref pour creer var

onBeforeMount(async() => {
   let response= await axiosInstance.get('/admin/animateurs');
   console.log(response);

 // code to DB
});


</script>