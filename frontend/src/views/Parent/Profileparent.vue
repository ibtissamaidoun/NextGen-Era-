<script setup>
import { ref } from 'vue';
import { onBeforeMount, onMounted, onBeforeUnmount } from 'vue';
import { useStore } from 'vuex';
import setNavPills from '@/assets/js/nav-pills.js';
import setTooltip from '@/assets/js/tooltip.js';
import ArgonInput from '@/components/ArgonInput.vue';
import ArgonModal from '@/components/ArgonModal.vue';
import { useForm, useField } from 'vee-validate';
import * as yup from 'yup';
import axiosInstance from '@/axios-instance';
const body = document.getElementsByTagName('body')[0];
const store = useStore();
const userProfile = ref({});
const showModal = ref(false);
const showPasswordModal = ref(false);
const profileImage = ref(null);
const id = ref(''); // Assurez-vous que cette initialisation est correcte
const email = ref('');
const phoneNumber = ref('');
const firstName = ref('');
const lastName = ref('');
const landline = ref('');
// const name = ref('Oulad Maalem Ayoub');
// const id = ref('1');
// const email = ref('ouladmaalem.ayoub@gmail.com');
// const firstName = ref('Oulad Maalem');
// const lastName = ref('Ayoub');
// const phoneNumber = ref('0682968795');
onMounted(async () => {
  try {
    const response = await axiosInstance.get('/user-profile');
    console.log("Réponse de l'API:", response.data);
    userProfile.value = response.data;
    id.value = userProfile.value.id;
    email.value = userProfile.value.email;
    phoneNumber.value = userProfile.value.telephone_portable;
    firstName.value = userProfile.value.nom;
    lastName.value = userProfile.value.prenom;
    landline.value = userProfile.value.telephone_fixe;

    // emailValue.value = userProfile.value.email;
    // phoneNumberValue.value = userProfile.value.telephone_portable;
    // firstNameValue.value = userProfile.value.nom;
    // lastNameValue.value = userProfile.value.prenom;
    // landlineValue.value = userProfile.value.telephone_fixe;
  } catch (error) {
    console.error('Failed to fetch user profile:', error);
  }
});
const { handleSubmit} = useForm({
     initialValues: {
       id: '',
       email: '',
       phoneNumber: '',
       firstName: '',
       lastName: '',
       landline: '',
      
     }
   });

   const { value: emailValue, errorMessage: emailError } = useField(
  'email',
  yup.string().required('L\'email est obligatoire').email('L\'email doit être valide')
);
const { value: phoneNumberValue, errorMessage: phoneNumberError } = useField(
  'phoneNumber',
  yup.string().required('Le numéro de téléphone est obligatoire').matches(/^0[67][0-9]{8}$/, 'Le numéro de téléphone doit commencer par 06 ou 07 et suivre de 8 chiffres')
);
const { value: landlineValue, errorMessage: landlineError } = useField(
  'landline',
  yup.string().required('Le téléphone fixe est obligatoire').matches(/^05[0-9]{8}$/, 'Le téléphone fixe doit commencer par 05 et suivre de 8 chiffres')
);
const { value: firstNameValue, errorMessage: firstNameError } = useField(
  'firstName',
  yup.string().required('Le nom est obligatoire')
);

const { value: lastNameValue, errorMessage: lastNameError } = useField(
  'lastName',
  yup.string().required('Le prénom est obligatoire')
);
const onSubmit = handleSubmit(async () => {
  try {
    const response = await axiosInstance.put('dashboard-parents/profile/', {
      id: id.value,
      email: emailValue.value,
      telephone_portable: phoneNumberValue.value,
      nom: firstNameValue.value,
      prenom: lastNameValue.value,
      telephone_fixe: landlineValue.value
    });
    console.log('Update Response:', response);
    alert('Profil mis à jour avec succès!');
  } catch (error) {
    console.error('Failed to update profile:', error);
    alert('Échec de la mise à jour du profil.');
  }
});

const updatePassword = async () => {
  try {
    const response = await axiosInstance.put('dashboard-parents/profile/update/password', {
      mot_de_passe_old: currentPassword.value,
      mot_de_passe_new: newPassword.value
    });
    console.log('Password Update Response:', response);
    alert('Mot de passe mis à jour avec succès!');
  } catch (error) {
    console.error('Failed to update password:', error);
    alert('Échec de la mise à jour du mot de passe.');
  }
};

const deleteProfile = async () => {
  try {
    const response = await axiosInstance.delete('dashboard-parents/profile/');
    console.log('Delete Response:', response);
    alert('Profil supprimé avec succès!');
    // Rediriger l'utilisateur ou actualiser la page si nécessaire
  } catch (error) {
    console.error('Failed to delete profile:', error);
    alert('Échec de la suppression du profil.');
  }
};

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
                <h5 class="mb-1">{{ firstName }} {{ lastName }} </h5>
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
                <button class="btn btn-danger ms-3"  @click="deleteProfile">Supprimer le profil</button>
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
        <argon-input type="email" v-model="emailValue" />
        <span>{{ emailError }}</span>
      </div>
      <div class="form-group">
        <label for="firstName" class="form-control-label">First name</label>
        <argon-input type="text" v-model="firstNameValue" />
        <span>{{ firstNameError }}</span>
      </div>
      <div class="form-group">
        <label for="lastName" class="form-control-label">Last name</label>
        <argon-input type="text" v-model="lastNameValue" />
        <span>{{ lastNameError }}</span>
      </div>
      <div class="form-group">
        <label for="phoneNumber" class="form-control-label">Téléphone portable</label>
        <argon-input type="text" v-model="phoneNumberValue" />
        <span>{{ phoneNumberError }}</span>
      </div>
      <div class="form-group">
        <label for="landline" class="form-control-label">Téléphone fixe</label>
        <argon-input type="text" v-model="landlineValue" />
        <span>{{ landlineError }}</span>
      </div>
    </template>
    <template #footer>
      <button class="btn btn-secondary" @click="showModal = false">Fermer</button>
      <button class="btn btn-primary" @click="onSubmit">Enregistrer</button>
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
      <button class="btn btn-primary" @click="updatePassword">Enregistrer</button>
    </template>
  </argon-modal>
</template>

<style scoped>
/* Styles personnalisés ici */
</style>
