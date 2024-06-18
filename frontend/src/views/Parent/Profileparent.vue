<script setup>
import { ref } from 'vue';
import { onBeforeMount, onMounted, onBeforeUnmount } from 'vue';
import { useStore } from 'vuex';
import setNavPills from '@/assets/js/nav-pills.js';
import setTooltip from '@/assets/js/tooltip.js';
import ArgonInput from '@/components/ArgonInput.vue';
import ArgonModal from '@/components/ArgonModal.vue';

const body = document.getElementsByTagName('body')[0];
const store = useStore();

const showModal = ref(false);
const showPasswordModal = ref(false);
const profileImage = ref(null);
const name = ref('Oulad Maalem Ayoub');
const id = ref('1');
const email = ref('ouladmaalem.ayoub@gmail.com');
const firstName = ref('Oulad Maalem');
const lastName = ref('Ayoub');
const phoneNumber = ref('0682968795');
const landline = ref('');
const currentPassword = ref('');
const newPassword = ref('');

function handleImageUpload(event) {
  const file = event.target.files[0];
  if (file) {
    profileImage.value = URL.createObjectURL(file);
  }
}

onMounted(() => {
  store.state.isAbsolute = true;
  setNavPills();
  setTooltip();
});
onBeforeMount(() => {
  store.state.imageLayout = 'profile-overview';
  store.state.showNavbar = false;
  store.state.showFooter = true;
  store.state.hideConfigButton = true;
  body.classList.add('profile-overview');
});
onBeforeUnmount(() => {
  store.state.isAbsolute = false;
  store.state.imageLayout = 'default';
  store.state.showNavbar = true;
  store.state.showFooter = true;
  store.state.hideConfigButton = false;
  body.classList.remove('profile-overview');
});
</script>

<template>
  <main>
    <div class="container-fluid">
      <div
        class="page-header min-height-300"
        style="
          background-image: url('https://www.bhmpics.com/downloads/blue-orange-Wallpapers/33.360_f_391417314_ew79dbyowbbcjmmhqchcijtdlpo522n7.jpg');
          margin-right: -24px;
          margin-left: -34%;
        "
      >
      </div>
      <div class="card shadow-lg mt-n6">
        <div class="card-body p-3">
          <div class="row gx-4">
            <div class="col-auto">
              <div class="avatar avatar-xl position-relative">
                <img :src="profileImage" alt="Profile Image" class="w-100 border-radius-lg shadow-sm">
                <input type="file" @change="handleImageUpload" class="form-control-file position-absolute" style="top: 0; left: 0; opacity: 0; width: 100%; height: 100%;">
              </div>
            </div>
            <div class="col-auto my-auto">
              <div class="h-100">
                <h5 class="mb-1">{{ name }}</h5>
                <p class="mb-0 font-weight-bold text-sm">parent</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="py-4 container-fluid">
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <button class="btn btn-dark" @click="showModal = true" style="background-color: navy;">Editer</button>
                <button class="btn btn-danger ms-3" @click="showPasswordModal = true">Modifier le mot de passe</button>
                <button class="btn btn-danger ms-3">Supprimer le profil</button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <label for="id" class="form-control-label">Id</label>
                  <argon-input type="text" v-model="id" />
                </div>
                <div class="col-md-6">
                  <label for="email" class="form-control-label">Email </label>
                  <argon-input type="email" v-model="email" />
                </div>
                <div class="col-md-6">
                  <label for="firstName" class="form-control-label">Nom</label>
                  <argon-input type="text" v-model="firstName" />
                </div>
                <div class="col-md-6">
                  <label for="lastName" class="form-control-label">Prénom</label>
                  <argon-input type="text" v-model="lastName" />
                </div>
                <div class="col-md-6">
                  <label for="phoneNumber" class="form-control-label">Téléphone portable</label>
                  <argon-input type="text" v-model="phoneNumber" />
                </div>
                <div class="col-md-6">
                  <label for="landline" class="form-control-label">Téléphone fixe</label>
                  <argon-input type="text" v-model="landline" />
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <argon-modal v-if="showModal" @close="showModal = false">
    <template #header>
      <h5 class="modal-title">Editer le profil</h5>
    </template>
    <template #body>
      <div class="form-group">
        <label for="id" class="form-control-label">Id</label>
        <argon-input type="text" v-model="id" />
      </div>
      <div class="form-group">
        <label for="email" class="form-control-label">Email address</label>
        <argon-input type="email" v-model="email" />
      </div>
      <div class="form-group">
        <label for="firstName" class="form-control-label">First name</label>
        <argon-input type="text" v-model="firstName" />
      </div>
      <div class="form-group">
        <label for="lastName" class="form-control-label">Last name</label>
        <argon-input type="text" v-model="lastName" />
      </div>
      <div class="form-group">
        <label for="phoneNumber" class="form-control-label">Téléphone portable</label>
        <argon-input type="text" v-model="phoneNumber" />
      </div>
      <div class="form-group">
        <label for="landline" class="form-control-label">Téléphone fixe</label>
        <argon-input type="text" v-model="landline" />
      </div>
    </template>
    <template #footer>
      <button class="btn btn-secondary" @click="showModal = false">Fermer</button>
      <button class="btn btn-primary" @click="showModal = false">Enregistrer</button>
    </template>
  </argon-modal>

  <argon-modal v-if="showPasswordModal" @close="showPasswordModal = false">
    <template #header>
      <h5 class="modal-title">Modifier le mot de passe</h5>
    </template>
    <template #body>
      <div class="form-group">
        <label for="currentPassword" class="form-control-label">Mot de passe actuel</label>
        <argon-input type="password" v-model="currentPassword" />
      </div>
      <div class="form-group">
        <label for="newPassword" class="form-control-label">Nouveau mot de passe</label>
        <argon-input type="password" v-model="newPassword" />
      </div>
    </template>
    <template #footer>
      <button class="btn btn-secondary" @click="showPasswordModal = false">Fermer</button>
      <button class="btn btn-primary" @click="showPasswordModal = false">Enregistrer</button>
    </template>
  </argon-modal>
</template>

<style scoped>
/* Styles personnalisés ici */
</style>
